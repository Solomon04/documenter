<h1 align="center">
    Laravel REST API Documenter
    <br>
    <img src="/example.png" alt="example" height="300">
</h1>

<p align="center">
  <img src="https://circleci.com/gh/Solomon04/documentation.svg" alt="CircleCI">
  <a href="https://packagist.org/packages/solomon04/documentation"><img src="https://poser.pugx.org/solomon04/documentation/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/solomon04/documentation"><img src="https://poser.pugx.org/solomon04/documentation/v/stable.svg" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/solomon04/documentation"><img src="https://poser.pugx.org/solomon04/documentation/license.svg" alt="License"></a>
</p>

### Generate Documentation for your REST API

This package allows you to generate documentation for your REST API via annotations. The markdown is then served by [LaRecipe](https://larecipe.binarytorch.com.my/) to generate beautiful documentation for your API. 

**Note this package is NOT stable. I've used it for only one of my repo's.** 

### Getting Started

- Install [LaRecipe](https://larecipe.binarytorch.com.my/) before starting. 
- Response examples must be stored in the `storage/` directory. 
- Do not use commas inside your annotation strings, it will break the documentation reader.

### Example

#### Input:
~~~php
use Solomon04\Documentation\Annotation\BodyParam;
use Solomon04\Documentation\Annotation\Group;
use Solomon04\Documentation\Annotation\QueryParam;
use Solomon04\Documentation\Annotation\ResponseExample;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @Group(name="Foo", description="This is an example group.")
 */
class FooController extends Controller
{
    /**
     * @Meta(name="Example Response", description="This is an example endpoint.", href="example")
     * @BodyParam(name="username", type="string", status="required", description="The username or email of the user", example="business_admin")
     * @QueryParam(name="limit", type="numeric", status="optional", description="The limit", example="1")
     * @ResponseExample(status=200, example="responses/")
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function bar(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', 'string'],
            'limit' => ['numeric']
        ]);
        return response()->json(['foo' => 'bar']);
    }
}
~~~

#### Output:
TODO

### Demo

View an [example](https://iamsolomon.io) of documentation using the Laravel REST API Documenter. 

### Tutorial 

View a video tutorial [here](https://youtube.com)