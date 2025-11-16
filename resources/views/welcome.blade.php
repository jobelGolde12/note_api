<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - Notes API Tester</title>

    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --card-radius: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            margin: 0;
            padding: 40px 20px;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .app-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            font-weight: 400;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .requests-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .response-section {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: "";
            display: block;
            width: 4px;
            height: 20px;
            background: var(--primary);
            border-radius: 2px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .card h2 {
            margin-top: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card h2::before {
            content: "";
            display: block;
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
        }

        label {
            font-size: 0.9rem;
            margin-top: 12px;
            display: block;
            font-weight: 500;
            color: var(--dark);
        }

        input, textarea {
            width: 100%;
            padding: 12px 16px;
            margin-top: 6px;
            border: 1px solid #e1e5eb;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        button {
            margin-top: 16px;
            width: 100%;
            padding: 14px;
            background: var(--primary);
            border: none;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .response-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .response-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .response-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            background: #e9ecef;
            color: var(--gray);
        }

        .response-content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            white-space: pre-wrap;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9rem;
            overflow: auto;
            max-height: 600px;
            border: 1px solid #e9ecef;
        }

        .method-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 8px;
        }

        .method-get {
            background: #e7f5ff;
            color: #228be6;
        }

        .method-post {
            background: #e6fcf5;
            color: #20c997;
        }

        .method-put {
            background: #fff9db;
            color: #fab005;
        }

        .method-delete {
            background: #fff5f5;
            color: #fa5252;
        }

        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .response-section {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="app-container">
        <header>
            <h1>Notes API Tester</h1>
            <p class="subtitle">Test your API endpoints with this modern interface</p>
        </header>

        <div class="main-content">
            <div class="requests-section">
                <h2 class="section-title">API Requests</h2>
                
                <!-- GET ALL NOTES -->
                <div class="card">
                    <h2><span class="method-badge method-get">GET</span> Get All Notes</h2>
                    <button onclick="getAllNotes()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 8V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Fetch All Notes
                    </button>
                </div>

                <!-- GET NOTE BY ID -->
                <div class="card">
                    <h2><span class="method-badge method-get">GET</span> Get Note By ID</h2>
                    <label>Note ID</label>
                    <input id="getNoteId" type="number" placeholder="Enter Note ID">
                    <button onclick="getNote()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Fetch Note
                    </button>
                </div>

                <!-- CREATE NOTE -->
                <div class="card">
                    <h2><span class="method-badge method-post">POST</span> Create Note</h2>
                    <label>Title</label>
                    <input id="createTitle" type="text" placeholder="Enter note title">
                    <label>Content</label>
                    <textarea id="createContent" placeholder="Enter note content" rows="3"></textarea>
                    <button onclick="createNote()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Create Note
                    </button>
                </div>

                <!-- UPDATE NOTE -->
                <div class="card">
                    <h2><span class="method-badge method-put">PUT</span> Update Note</h2>
                    <label>Note ID</label>
                    <input id="updateId" type="number" placeholder="Enter note ID">
                    <label>Title</label>
                    <input id="updateTitle" type="text" placeholder="Enter new title">
                    <label>Content</label>
                    <textarea id="updateContent" placeholder="Enter new content" rows="3"></textarea>
                    <button onclick="updateNote()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 5H6C4.89543 5 4 5.89543 4 7V18C4 19.1046 4.89543 20 6 20H17C18.1046 20 19 19.1046 19 18V13M17.5858 3.58579C18.3668 2.80474 19.6332 2.80474 20.4142 3.58579C21.1953 4.36683 21.1953 5.63316 20.4142 6.41421L11.8284 15H9L9 12.1716L17.5858 3.58579Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Update Note
                    </button>
                </div>

                <!-- DELETE NOTE -->
                <div class="card">
                    <h2><span class="method-badge method-delete">DELETE</span> Delete Note (Soft Delete)</h2>
                    <label>Note ID</label>
                    <input id="deleteId" type="number" placeholder="Enter note ID to delete">
                    <button onclick="deleteNote()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 7L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 7M10 11V17M14 11V17M15 7V4C15 3.44772 14.5523 3 14 3H10C9.44772 3 9 3.44772 9 4V7M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Delete Note
                    </button>
                </div>

                <!-- RESTORE NOTE -->
                <div class="card">
                    <h2><span class="method-badge method-put">PUT</span> Restore Soft Deleted Note</h2>
                    <label>Note ID</label>
                    <input id="restoreId" type="number" placeholder="Enter note ID to restore">
                    <button onclick="restoreNote()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.5 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8.5L14.5 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 2V9H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Restore Note
                    </button>
                </div>

                <!-- FAVORITE -->
                <div class="card">
                    <h2><span class="method-badge method-put">PUT</span> Favorite Note</h2>
                    <label>Note ID</label>
                    <input id="favoriteId" type="number" placeholder="Enter note ID to favorite">
                    <button onclick="favoriteNote()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 8.25C21 5.76472 18.9013 3.75 16.3125 3.75C14.3769 3.75 12.7153 4.87628 12 6.48342C11.2847 4.87628 9.62312 3.75 7.6875 3.75C5.09867 3.75 3 5.76472 3 8.25C3 15.4706 12 20.25 12 20.25C12 20.25 21 15.4706 21 8.25Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Favorite Note
                    </button>
                </div>

                <!-- UNFAVORITE -->
                <div class="card">
                    <h2><span class="method-badge method-put">PUT</span> Unfavorite Note</h2>
                    <label>Note ID</label>
                    <input id="unfavoriteId" type="number" placeholder="Enter note ID to unfavorite">
                    <button onclick="unfavoriteNote()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 8.25C21 5.76472 18.9013 3.75 16.3125 3.75C14.3769 3.75 12.7153 4.87628 12 6.48342C11.2847 4.87628 9.62312 3.75 7.6875 3.75C5.09867 3.75 3 5.76472 3 8.25C3 15.4706 12 20.25 12 20.25C12 20.25 21 15.4706 21 8.25Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Unfavorite Note
                    </button>
                </div>
            </div>

            <div class="response-section">
                <h2 class="section-title">API Response</h2>
                <div class="card response-card">
                    <div class="response-header">
                        <h2>Response</h2>
                        <div class="response-status" id="response-status">Ready</div>
                    </div>
                    <div class="response-content" id="response-box">
                        Waiting for API response...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showResponse(data, status = "Success") {
            document.getElementById('response-box').textContent = JSON.stringify(data, null, 2);
            document.getElementById('response-status').textContent = status;
            
            // Update status color based on response
            const statusElement = document.getElementById('response-status');
            if (status === "Error") {
                statusElement.style.background = "#fff5f5";
                statusElement.style.color = "#e03131";
            } else {
                statusElement.style.background = "#e6fcf5";
                statusElement.style.color = "#0ca678";
            }
        }

        function handleError(error) {
            showResponse({ error: error.message }, "Error");
        }

        // GET ALL NOTES
        function getAllNotes() {
            fetch('/api/notes')
                .then(res => res.json())
                .then(data => showResponse(data))
                .catch(handleError);
        }

        // GET NOTE BY ID
        function getNote() {
            let id = document.getElementById('getNoteId').value;
            if (!id) {
                showResponse({ error: "Please enter a Note ID" }, "Error");
                return;
            }
            
            fetch(`/api/notes/${id}`)
                .then(res => res.json())
                .then(data => showResponse(data))
                .catch(handleError);
        }

        // CREATE NOTE
        function createNote() {
            const title = document.getElementById('createTitle').value;
            const content = document.getElementById('createContent').value;
            
            if (!title || !content) {
                showResponse({ error: "Please fill in both title and content" }, "Error");
                return;
            }
            
            fetch('/api/notes', {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    title: title,
                    content: content
                })
            })
            .then(res => res.json())
            .then(data => showResponse(data))
            .catch(handleError);
        }

        // UPDATE NOTE
        function updateNote() {
            let id = document.getElementById('updateId').value;
            
            if (!id) {
                showResponse({ error: "Please enter a Note ID" }, "Error");
                return;
            }

            fetch(`/api/notes/${id}`, {
                method: "PUT",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    title: document.getElementById('updateTitle').value,
                    content: document.getElementById('updateContent').value
                })
            })
            .then(res => res.json())
            .then(data => showResponse(data))
            .catch(handleError);
        }

        // DELETE NOTE (soft delete)
        function deleteNote() {
            let id = document.getElementById('deleteId').value;
            
            if (!id) {
                showResponse({ error: "Please enter a Note ID" }, "Error");
                return;
            }

            fetch(`/api/notes/${id}`, {
                method: "DELETE"
            })
            .then(res => res.json())
            .then(data => showResponse(data))
            .catch(handleError);
        }

        // RESTORE NOTE
        function restoreNote() {
            let id = document.getElementById('restoreId').value;
            
            if (!id) {
                showResponse({ error: "Please enter a Note ID" }, "Error");
                return;
            }

            fetch(`/api/notes/${id}/restore`, {
                method: "PUT"
            })
            .then(res => res.json())
            .then(data => showResponse(data))
            .catch(handleError);
        }

        // FAVORITE
        function favoriteNote() {
            let id = document.getElementById('favoriteId').value;
            
            if (!id) {
                showResponse({ error: "Please enter a Note ID" }, "Error");
                return;
            }

            fetch(`/api/notes/${id}/favorite`, {
                method: "PUT"
            })
            .then(res => res.json())
            .then(data => showResponse(data))
            .catch(handleError);
        }

        // UNFAVORITE
        function unfavoriteNote() {
            let id = document.getElementById('unfavoriteId').value;
            
            if (!id) {
                showResponse({ error: "Please enter a Note ID" }, "Error");
                return;
            }

            fetch(`/api/notes/${id}/unfavorite`, {
                method: "PUT"
            })
            .then(res => res.json())
            .then(data => showResponse(data))
            .catch(handleError);
        }
    </script>
</body>
</html>