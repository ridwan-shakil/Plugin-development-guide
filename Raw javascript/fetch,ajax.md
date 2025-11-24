# JavaScript AJAX Notes

## Introduction

AJAX (Asynchronous JavaScript and XML) allows JavaScript to communicate
with servers **without reloading the page**.\
Modern AJAX uses the **fetch API**, which returns Promises.


✔ Send Request/data (from frontend js -> to own backend or external API) 
✔ Receive response (from backend php) 
✔ Handle success or error (js) 
✔ Update the UI  

------------------------------------------------------------------------

## When to Use AJAX

Use AJAX when you need to: - Load data dynamically - Submit forms
without page reload - Update UI instantly - Communicate with REST APIs -
Save plugin settings asynchronously - Build admin UI interactions

------------------------------------------------------------------------

## How to Use AJAX

AJAX calls generally follow this pattern:

1.  Call the server using `fetch()`
2.  Wait for the response using `await`
3.  Convert response to JSON
4.  Handle errors properly

------------------------------------------------------------------------

## GET Request (fetch data)

``` js
async function getUsers() {
    const res = await fetch("https://jsonplaceholder.typicode.com/users");
    const data = await res.json();
    console.log(data);
}
```

------------------------------------------------------------------------

## POST Request (send data)

``` js
async function createPost() {
    const res = await fetch("https://jsonplaceholder.typicode.com/posts", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: "New Post", body: "Content here" })
    });
    const data = await res.json();
    console.log(data);
}
```

------------------------------------------------------------------------

## PUT/PATCH Request (update data)

``` js
async function updatePost() {
    const res = await fetch("https://jsonplaceholder.typicode.com/posts/1", {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: "Updated Title" })
    });
    const data = await res.json();
    console.log(data);
}
```

------------------------------------------------------------------------

## DELETE Request (remove data)

``` js
async function deletePost() {
    const res = await fetch("https://jsonplaceholder.typicode.com/posts/1", {
        method: "DELETE"
    });
    console.log("Deleted:", res.status);
}
```

------------------------------------------------------------------------

## Important Points

-   `fetch` does not auto-handle errors --- you must catch them.
-   Always check `res.ok` before using `res.json()`.
-   Use headers when sending JSON.
-   For form submissions, use `FormData` or `URLSearchParams`.
-   AJAX is essential for modern WordPress plugin development.

------------------------------------------------------------------------








Here is the typical structure:

```php
async function sendData() {
  try {
    const response = await fetch("/wp-json/myplugin/v1/save", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify({name: "Ridwan"})
    });

    if (!response.ok) {
      throw new Error("Server error " + response.status);
    }

    const data = await response.json();
    console.log("Success:", data);

  } catch (error) {
    console.log("Error:", error);
  }
}
```


