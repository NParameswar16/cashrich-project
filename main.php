<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #D3D3D3;
            transition: background-color 0.5s, color 0.5s;
        }
        .navbar {
            background-color: white;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.5s;
        }
        .navbar-brand img {
            height: 50px;
            width: 200px;
        
        }
        .logout-link {
            font-size: 14px;
        }
        .logout-link a {
            color: #007bff;
            text-decoration: none;
        }
        .logout-link a:hover {
            text-decoration: underline;
        }
        .search-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 80vh;
            text-align: center;
        }
        .search-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-control {
            margin-right: 10px;
        }
        .btn {
            width: 100px !important;
            height: 36px;
            left: -7px;
        }
       

        body.dark-mode {
            background-color: #121212;
            color: white;
        }
        .navbar.dark-mode {
            background-color: #333;
            color: white;
        }
        .form-control.dark-mode {
            background-color: #333;
            color: white;
            border: 1px solid #444;
        }
        .mode-switcher{
            margin-right: 5px;
            margin-left: 15px;
        }


        .logout-link.dark-mode a {
            color: #bbb;
        }
        .btn-mode-toggle {
            background-color: black;
            color:white;
            transition: background-color 0.5s, color 0.5s;
        }
        .btn-mode-toggle.dark-mode {
            background-color: white;
            color: black;
        }

  
        @media (max-width: 992px) {
           
            .navbar-brand img {
                width: 150px;
                height: 40px;
            }
        }

        @media (max-width: 768px) {
            
            .navbar {
                flex-direction: column;
                padding: 15px;
                text-align: center;
            }
            .logout-link {
                font-size: 12px;
            }
            .navbar-brand img {
                width: 150px;
            }
        }

        @media (max-width: 576px) {
           
            .search-container h2 {
                font-size: 18px;
            }
            .btn {
                width: 90px !important;
                height: 34px;
            }
            .form-control {
                font-size: 14px;
                margin-bottom: 10px;
            }
            .input-group {
                flex-direction: column;
                align-items: center;
            }
            .input-group .form-control, .input-group .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            .navbar-brand img {
                width: 100px;
                height: 30px;
                justify-content:space-between;
                margin-left: -23px;
                margin-top: -15px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex flex-grow-1 justify-content-center">
            <a class="navbar-brand" href="#">
                <img src="logo2.png" alt="Logo">
            </a>
        </div>
        
        <!-- Logout link -->
        <div class="logout-link text-end">
            <span><?php echo $_SESSION['email']; ?></span>
            <br>
            <a href="login.php">Logout</a>
        </div>

        <!-- Dark Mode Switch -->
        <div class="mode-switcher text-end">
            <button id="toggleMode" class="btn btn-mode-toggle">Dark</button>
        </div>
    </div>
</nav>

<!-- Search Form -->
<div class="search-container">
    <h2>Search</h2>
    <div class="input-group mb-3" style="max-width: 400px; width: 100%;">
        <input type="text" class="form-control" id="searchInput" placeholder="Enter coin symbols" aria-label="Enter coin symbols">
        <button id="searchBtn" class="btn btn-dark" type="button">Search</button>
    </div>
    <div id="searchResults" class="mt-3"></div>
</div>

<script>
    // Dark Mode Toggle Script
    const toggleMode = document.getElementById('toggleMode');
    const body = document.body;
    const formControl = document.querySelector('.form-control');
    const navbar = document.querySelector('.navbar');
    const logoutLink = document.querySelector('.logout-link');
    const searchBtn = document.getElementById('searchBtn');

    
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        formControl.classList.add('dark-mode');
        navbar.classList.add('dark-mode');
        logoutLink.classList.add('dark-mode');
        searchBtn.classList.replace('btn-dark', 'btn-light');
        toggleMode.classList.add('dark-mode');
        toggleMode.textContent = 'Light';
    }

    toggleMode.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        formControl.classList.toggle('dark-mode');
        navbar.classList.toggle('dark-mode');
        logoutLink.classList.toggle('dark-mode');
        toggleMode.classList.toggle('dark-mode');
        searchBtn.classList.toggle('btn-dark');
        searchBtn.classList.toggle('btn-light');

        if (body.classList.contains('dark-mode')) {
            toggleMode.textContent = 'Light';
            localStorage.setItem('theme', 'light'); 
        } else {
            toggleMode.textContent = 'Dark';
            localStorage.setItem('theme', 'light'); 
        }
    });
</script>

<!-- Search Results -->
<script>
    document.getElementById('searchBtn').addEventListener('click', async () => {
        const coinSymbol = document.getElementById('searchInput').value.toUpperCase(); 
        const apiKey = '27ab17d1-215f-49e5-9ca4-afd48810c149'; 
        const apiUrl = `https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=${coinSymbol}`;

        try {
            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'X-CMC_PRO_API_KEY': apiKey,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            displayResults(data);
        } catch (error) {
            console.error('Error fetching data:', error);
            document.getElementById('searchResults').innerText = 'Error fetching data. Please try again.';
        }
    });

    function displayResults(data) {
        const resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = ''; 

       
        if (data.data) {
            Object.keys(data.data).forEach(symbol => {
                const coin = data.data[symbol];
                const resultHTML = `
                    <div>
                        <h4>${coin.symbol} (${coin.name})</h4>
                        <p>CMC Rank: ${coin.cmc_rank}</p>
                        <p>Price (USD): $${coin.quote.USD.price.toFixed(2)}</p>
                        <p>24h Change: ${coin.quote.USD.percent_change_24h.toFixed(2)}%</p>
                    </div>
                `;
                resultsContainer.innerHTML += resultHTML; 
            });
        } else {
            resultsContainer.innerHTML = 'No results found for the provided symbol.';
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
