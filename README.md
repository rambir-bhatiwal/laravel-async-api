# 📘 API Documentation: PHP REST API with Asynchronous Processing

## 📌 Base URL:

```
http://127.0.0.1:8000/api
```

---

## 🚀 1. Submit a Task

-   **Endpoint:** `/task`
-   **Method:** POST
-   **Request Body:**

```json
{
    "input": "hello"
}
```

-   **Response Example:**

```json
{
    "task_id": "uuid-here",
    "status": "pending"
}
```

---

## 🔄 2. Check Task Status

-   **Endpoint:** `/task/{task_id}/status`
-   **Method:** GET
-   **Response Example:**

```json
{
    "task_id": "uuid-here",
    "status": "completed"
}
```

-   **Error (if task not found):**

```json
{
    "message": "Task not found"
}
```

---

## 📥 3. Get Task Result

-   **Endpoint:** `/task/{task_id}/result`
-   **Method:** GET

-   **Response (Completed):**

```json
{
    "task_id": "uuid-here",
    "result": "olleh"
}
```

-   **If Still Processing:**

```json
{
    "message": "Task not finished yet",
    "status": "processing"
}
```

-   **If Failed:**

```json
{
    "message": "Task processing failed"
}
```

---

## ⚙️ Asynchronous Mechanism

-   Laravel's **queue system** is used (`database` driver).
-   A **background worker** processes each task.
-   The task moves from `pending` → `processing` → `completed`.

---

---

## 🧾 How to Run the Project

```bash
# Clone the project
git clone https://github.com/rambir-bhatiwal/laravel-async-api.git
cd laravel-async-api

# Install dependencies
composer install

# Set up .env file
cp .env.example .env
php artisan key:generate

# Set up database
# (Edit your .env DB settings accordingly)
php artisan migrate

# Start Laravel server
php artisan serve
```

---

## ▶️ Start Queue Worker

In a new terminal window/tab:

```bash
php artisan queue:work
```

---

## 🤔 Why Laravel?

-   Modern structure.
-   Built-in support for queues and jobs.
-   Clean, scalable API development.

---

## 📉 Error Handling

| Scenario          | Response           |
| ----------------- | ------------------ |
| Task not found    | 404 - JSON message |
| Task failed       | 500 - JSON message |
| Task not complete | 202 - wait message |

---

## 🧪 Test Tools

Use Postman or any API client.

---

## 🔁 How Async Works

-   Task is saved to DB and queued.
-   Laravel's `queue:work` command runs in background.
-   Job class processes input (like reverse string).
-   Status and result are updated in DB.

---

## ✅ Example Task Logic

The example task simply reverses the input string after a delay (to simulate heavy processing).

---

## ✍️ Author

Made with ❤️ by Rambir

## 🔚 End of Documentation
