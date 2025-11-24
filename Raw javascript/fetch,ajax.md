This is the pattern you will repeat in almost every plugin you build:

✔ Send data (from frontend - js)
✔ Receive response (from backend - php)
✔ Handle success or error (js)
✔ Update the UI 

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


