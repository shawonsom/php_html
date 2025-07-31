<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log File Search</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        select, input[type="text"] { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #218838; }
        #results { margin-top: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background: #eee; min-height: 100px; white-space: pre-wrap; }
    </style>
</head>
<body>

<div class="container">
    <h1>Log File Search</h1>
    <div class="form-group">
        <label for="folder-select">Select a folder:</label>
        <select id="folder-select"></select>
    </div>
    <div class="form-group">
        <label for="file-select">Select a file:</label>
        <select id="file-select"></select>
    </div>
    <div class="form-group">
        <label for="search-keyword">Search Keyword:</label>
        <input type="text" id="search-keyword" placeholder="Enter keyword...">
    </div>
    <button id="search-button">Search</button>
    <div id="results">
        <p>Results will appear here...</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const folderSelect = document.getElementById('folder-select');
        const fileSelect = document.getElementById('file-select');
        const searchButton = document.getElementById('search-button');
        const searchKeyword = document.getElementById('search-keyword');
        const resultsDiv = document.getElementById('results');

        // Fetch folder list on page load
        fetch('scan_folders.php')
            .then(response => response.json())
            .then(folders => {
                folders.forEach(folder => {
                    const option = document.createElement('option');
                    option.value = folder;
                    option.textContent = folder;
                    folderSelect.appendChild(option);
                });
                // Load files for the default selected folder
                loadFiles(folderSelect.value);
            });

        // Handle folder selection change
        folderSelect.addEventListener('change', function() {
            loadFiles(this.value);
        });

        function loadFiles(folder) {
            fileSelect.innerHTML = ''; // Clear existing file options
            fetch(`scan.php?folder=${encodeURIComponent(folder)}`)
                .then(response => response.json())
                .then(files => {
                    if (files.error) {
                        alert(files.error);
                        return;
                    }
                    files.forEach(file => {
                        const option = document.createElement('option');
                        option.value = file;
                        option.textContent = file;
                        fileSelect.appendChild(option);
                    });
                });
        }

        // Handle search button click
        searchButton.addEventListener('click', function() {
            const selectedFolder = folderSelect.value;
            const selectedFile = fileSelect.value;
            const keyword = searchKeyword.value;

            if (!selectedFile) {
                alert('Please select a file.');
                return;
            }

            if (!keyword) {
                alert('Please enter a search keyword.');
                return;
            }

            resultsDiv.textContent = 'Searching...';

            fetch('search.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `folder=${encodeURIComponent(selectedFolder)}&file=${encodeURIComponent(selectedFile)}&keyword=${encodeURIComponent(keyword)}`
            })
            .then(response => response.text())
            .then(data => {
                resultsDiv.textContent = data ? data : 'No results found.';
            })
            .catch(error => {
                console.error('Error:', error);
                resultsDiv.textContent = 'An error occurred during the search.';
            });
        });
    });
</script>

</body>
</html>
