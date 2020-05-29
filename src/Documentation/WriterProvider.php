<?php


namespace Solomon04\Documentation;


use Solomon04\Documentation\Contracts\StringBlade;
use Solomon04\Documentation\Contracts\Writer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class WriterProvider implements Writer
{
    /**
     * @var StringBlade
     */
    private $stringBlade;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(StringBlade $stringBlade, Filesystem $filesystem)
    {
        $this->stringBlade = $stringBlade;
        $this->filesystem = $filesystem;
    }

    /**
     * Create the documentation menu
     *
     * @param Collection $namespaces
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function menu(Collection $namespaces)
    {
        $blade =  $this->filesystem->get(__DIR__ . '../../resources/views/menu-skeleton.blade.php');
        $markdown = $this->stringBlade->render($blade, ['namespaces' => $namespaces]);
        $markdown = $this->replaceBraces($markdown);
        $fileName = resource_path(config('larecipe.docs.route') . DIRECTORY_SEPARATOR . config('larecipe.versions.default') . DIRECTORY_SEPARATOR . 'index.md');

        return $this->filesystem->put($fileName, $markdown);
    }

    /**
     * Create the endpoint pages
     *
     * @param Collection $endpoints
     * @param string $name
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function page($endpoints, $name)
    {
        $blade = $this->filesystem->get(__DIR__ . '../../resources/views/page-skeleton.blade.php');
        $markdown = $this->stringBlade->render($blade, ['group' => $endpoints->group, 'endpoints' => $endpoints]);
        $markdown = $this->replaceQuotes($markdown);
        $path = resource_path(config('larecipe.docs.route') . DIRECTORY_SEPARATOR .config('larecipe.versions.default') . DIRECTORY_SEPARATOR . strtolower($name));
        $fileName = $path . DIRECTORY_SEPARATOR . str_replace(' ', '-', strtolower($endpoints->group->name)) .'.md';
        if(!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path);
        }

        return $this->filesystem->put($fileName, $markdown);
    }

    /**
     * Replace the escaped braces
     *
     * @param $markdown
     * @return string|string[]
     */
    private function replaceBraces($markdown)
    {
        $markdown = str_replace(array("&#123;"), '{', $markdown);
        return str_replace(array("&#125;"), '}', $markdown);
    }

    /**
     * Sometimes the json quotes aren't always escaped properly, so this replaces the &quot; in the markdown.
     *
     * @param $markdown
     * @return string|string[]
     */
    private function replaceQuotes($markdown)
    {
        return str_replace("&quot;", '"', $markdown);
    }
}
