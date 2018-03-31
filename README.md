# PHP Flat File CMS API
This repo serves as a very simple example of how you can create a Flat File CMS API using just one PHP file. Most modern web applications today will have both a frontend as well as a complex backend API that communicates with a database. This is an example of how you can set up a flat file content management system using just a PHP file and a secret key, enabling you to use cheap hosting (like Namecheap for example) that doesn't need to have NodeJS, Python, Java, or any other more complex backend language.

## Example
The example found in `store.php` enables adding data to a file named `shows.json`. I made this simple script because I wanted to set up a TV tracking app but not actually build any sort of backend API since that seemed like a bit of an overkill. You can definitely extend this to allow editing any file via a GET parameter but that could potentially open you up to a hacker creating whatever files they want on your website, given that they could only write JSON to them.

Note that there is literally no validation in this API, so it assumes that you are the one creating whatever interacts with the API and that you are extremely careful to not send malformed data. This would not work very well on a large team, but you could always use this as a base and expand upon it to add validation and more complex authentication.

## Using the API
### Key based authentication
Line 6 of `store.php` has the following line:

```
if($_GET['key'] == 'random_key') {
```

`random_key` should be updated to an actual random alphanumeric key that you want to use to authenticate against the PHP CRUD API. Note that anyone with the key could add, edit, and delete data so make sure it is both long and sufficiently random.

### Data Structure
This API assumes that you are creating an array of data, but each element in the array does not need to have the same structure. You can also have a single element array if you simply want to have a single entry. You may use any keys you want and assign any values, but the key `id` is reserved and indicates the index of the element in the array. You may assign a different value to `id` but it will be ignored and instead changed to be the index of the element.

### Add Endpoint
This endpoint appends an element to the array.

URL:

```
store.php?key=random_key&method=add
```

POST data example:
```
{"name":"curb enthusiasm"}
```
This would add the above element and also add the `id` key to the element and store it in `shows.json`.

More complex POST data:
```
{
  "name:"curb enthusiasm",
  "date":"2018-03-31",
  "airing": false
  "related-shows": [
    {"name":"seinfeld"}
  ]
}
```
You can literally put as much or little data as you want.

### Update Endpoint
This endpoint simply clobbers the data for the endpoint you provide and replaces it with the data you provide. If you do not include all keys, then the left out keys will be deleted.

URL:
```
store.php?key=random_key&method=update
```

POST data example:

```
{
  "id":0
  "name":"modern family"
}
```
This would update the first element in the array to have the only the data ``"name":"modern family"`` (and the implicit id).

### Delete Endpoint
Deletes the element with the id specified. All other keys will be ignored. The `id` indexes will be reset for all items to be in order.

URL:
```
store.php?key=random_key&method=delete
```

POST data example:

```
{
  "id":0
}
```
This would cause the element with `"id":1` to be reset to `"id":0` since the element with `"id":0` was deleted.

## More Information
A post on my website will be soon to follow, explaining much of the same details as above but with an example video of the TV tracking app that I made with this strategy. 
