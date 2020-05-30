<h1 align="center">
    Laravel REST API Documenter
    <br>
    <img src="/example.png" alt="example" height="600">
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

#### Install [LaRecipe](https://larecipe.binarytorch.com.my/)
It is mandatory you install the LaRecipe package in order to get the benefits of the API documenter. 

Install LaRecipe via composer.

`composer require binarytorch/larecipe`

Run the install command.

`php artisan larecipe:install`

#### Install Documenter

Install Documenter via composer

`composer require solomon04/documentation`

Publish provider

`php artisan vendor:publish --provider="Solomon04\Documentation\DocumentationServiceProvider"`


### Steps

1. Go to an API controller
2. Add [available annotations](#available-annotations) to the file. 
3. Run `php artisan docs:generate`


#### Available Annotations:

##### @Group

The group annotation is used to group endpoints within a single controller class. 

##### Attributes
- Name (required)
- Description (optional)

##### Example
```php
/**
 * @Group(name="Foo", description="This is an example group.")
 */
class FooController extends Controller
{

}
```

##### @Meta

The meta annotation is used to document a single endpoint. This would be a function within a controller class. 

##### Attributes
- Name (required)
- Href (required)
- Description (optional)

##### Example
```php
class FooController extends Controller
{
    /**
    * @Meta(name="Example", description="This is an example endpoint.", href="example")
     */
    public function bar()
    {
    
    }
}
```

##### @BodyParam

The body param annotation is used to document the available body parameters within a single endpoint request.

##### Attributes
- Name (required)
- Type (required)
- Status (required)
- Description (optional)
- Example (optional)

##### Example
```php
class FooController extends Controller
{
    /**
    * @BodyParam(name="foo", type="string", status="required", description="An example body paramater", example="bar")
     */
    public function bar(FormRequest $request)
    {
    
    }
}
```

##### @QueryParam

The query param annotation is used to document the available query parameters within a single endpoint request.

##### Attributes
- Name (required)
- Type (required)
- Status (required)
- Description (optional)
- Example (optional)

##### Example
```php
class FooController extends Controller
{
    /**
    * @QueryParam(name="foo", type="string", status="optional", description="An example query paramater", example="bar")
     */
    public function bar()
    {
    
    }
}
```

##### @ResponseExample

The response example annotation is used to give an example response for an endpoint. 

**Important Note:** Response example file must be stored in the `storage/` directory. 

##### Attributes
- Status (required)
- Example (required)

##### Example
```php
class FooController extends Controller
{
    /**
    * @ResponseExample(status=200, example="responses/example.json")
     */
    public function bar()
    {
        return response()->json(['foo' => 'bar']);
    }
}
```

### Demo Laravel App

View an [example](https://iamsolomon.io) of documentation using the Laravel REST API Documenter. 

### Tutorial 

View a video tutorial [here](https://youtube.com)