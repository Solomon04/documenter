<?php


namespace Solomon04\Documentation;


use Solomon04\Documentation\Annotation\BodyParam;
use Solomon04\Documentation\Annotation\Meta;
use Solomon04\Documentation\Annotation\QueryParam;
use Solomon04\Documentation\Annotation\ResponseExample;
use Solomon04\Documentation\Contracts\Extractor;
use App\Rules\ResponseExampleExists;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory as Validator;
use Illuminate\Validation\ValidationException;

class ExtractorProvider implements Extractor
{

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Filesystem $filesystem, Validator $validator)
    {
        $this->filesystem = $filesystem;
        $this->validator = $validator;
    }

    /**
     * Strip the response annotation from a controller.
     *
     * @param string $response
     * @return ResponseExample
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function response(string $response)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')' ), '', $response));
        $responses = [];
        $responseExample = new ResponseExample();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $responses[$name] = $data[1];
        }

        $validator = $this->validator->make($responses, [
            'status' => ['required', 'numeric', 'string'],
            'example' => ['string', new ResponseExampleExists()]
        ], ['example' => 'The response file was not found.']);

        if(!$validator->passes()) {
            throw new ValidationException($validator);
        }

        foreach ($responses as $item => $value) {
            $responseExample->$item = str_replace('"', '', $value);
        }

        $example = storage_path($responseExample->example);
        $responseExample->example = $this->filesystem->get($example);


        return $responseExample;
    }

    /**
     * Strip the meta annotation from the controller.
     *
     * @param string $meta
     * @return Meta|string
     * @throws ValidationException
     */
    public function meta(string $meta)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $meta));
        $meta = new Meta();
        $params = [];
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        $validator = $this->validator->make($params, [
            'name' => ['required', 'string'],
            'href' => ['required', 'string'],
            'description' => ['string']
        ]);

        if(!$validator->passes()) {
            throw new ValidationException($validator, $validator->errors()->messages());
        }

        foreach ($params as $item => $value) {
            $meta->$item = str_replace('"', '', $value);;
        }

        return $meta;
    }

    /**
     * Strip the group annotation from the controller.
     *
     * @param string $group
     * @return Meta|string
     * @throws ValidationException
     */
    public function group(string $group)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $group));
        $group = new Meta();
        $params = [];
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        $validator = $this->validator->make($params, [
            'name' => ['required', 'string'],
            'description' => ['string']
        ]);

        if(!$validator->passes()) {
            throw new ValidationException($validator);
        }

        foreach ($params as $item => $value) {
            $group->$item = str_replace('"', '', $value);
        }

        return $group;
    }

    /**
     * Strip the body param annotation from the controller.
     *
     * @param string $body
     * @return BodyParam|string
     * @throws ValidationException
     */
    public function body(string $body)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $body));
        $params = [];
        $body = new BodyParam();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        $validator = $this->validator->make($params, [
            'name' => ['required', 'string'],
        ]);

        if(!$validator->passes()) {
            throw new ValidationException($validator);
        }


        foreach ($params as $item => $value) {
            $body->$item = str_replace('"', '', $value);
        }


        return $body;
    }

    /**
     * Strip the query param annotation from the controller.
     *
     * @param string $query
     * @return QueryParam|string
     * @throws ValidationException
     */
    public function query(string $query)
    {
        $stringedArray = explode(',', str_replace(array( '(', ')'), '', $query));
        $params = [];
        $query = new QueryParam();
        foreach ($stringedArray as $arr) {
            $data = explode('=', $arr);

            $name = preg_replace('/\s+/', '', $data[0]);

            $params[$name] = $data[1];
        }

        $validator = $this->validator->make($params, [
            'name' => ['required', 'string'],
        ]);

        if(!$validator->passes()) {
            throw new ValidationException($validator);
        }


        foreach ($params as $item => $value) {
            $query->$item = str_replace('"', '', $value);
        }


        return $query;
    }

}
