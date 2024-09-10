<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>BookHaven Admin</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="icon" href="media/BH_Logo.png" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>
    <div id="top-header">
        <div id="logo"><img src="media/BH_Logo.png" /></div>
    </div>
    <h1>Book Haven Admin</h1>

    <li class="search-container">
        <form action="#">
            <input type="text" placeholder="Find books by title, author, ISBN" />
            <input type="submit" value="Search" />
        </form>
    </li>

    <nav>
        <ul>
            <li><a href="adminPage.php">Dashboard</a></li>
            <li><a href="adminManageBooks.php">Manage Books</a></li>
            <li><a href="adminViewBooks.php">View Books</a></li>
            <li><a href="adminViewOrders.php">View Orders</a></li>
            <li><a href="adminUser.php">Manage Users</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </nav>
</header> 

<h1>Admin Dashboard</h1>

<section class="card-container">
    <div class="card">
        <h2>Users</h2>
        <p id="user-count">0</p>
    </div>
    <div class="card">
        <h2>Orders</h2>
        <p id="order-count">0</p>
    </div>
    <div class="card">
        <h2>Books</h2>
        <p id="book-count">0</p>
    </div>
</section>

<section class="chart-container">
    <canvas id="countsChart" width="400" height="200"></canvas>
    <canvas id="userRoleChart" width="400" height="200"></canvas>
    <canvas id="dailyOrdersChart" width="400" height="200"></canvas>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch initial data
        fetch('getCounts.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('user-count').innerText = data.users;
                document.getElementById('order-count').innerText = data.orders;
                document.getElementById('book-count').innerText = data.books;

                // Bar chart (Counts)
                const ctxCounts = document.getElementById('countsChart').getContext('2d');
                const countsChart = new Chart(ctxCounts, {
                    type: 'bar',
                    data: {
                        labels: ['Users', 'Orders', 'Books'],
                        datasets: [{
                            label: 'Counts',
                            data: [data.users, data.orders, data.books],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Fetch user role data
                fetch('getUserRoles.php')
                    .then(response => response.json())
                    .then(roleData => {
                        const roleLabels = Object.keys(roleData);
                        const roleCounts = Object.values(roleData);

                        // Pie chart (User Roles)
                        const ctxRoles = document.getElementById('userRoleChart').getContext('2d');
                        const userRoleChart = new Chart(ctxRoles, {
                            type: 'pie',
                            data: {
                                labels: roleLabels,
                                datasets: [{
                                    label: 'User Roles',
                                    data: roleCounts,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching user roles:', error));

                // Fetch daily order data
                fetch('getDailyOrders.php')
                    .then(response => response.json())
                    .then(dailyData => {
                        const dates = Object.keys(dailyData);
                        const orders = Object.values(dailyData);

                        // Line chart (Daily Orders)
                        const ctxOrders = document.getElementById('dailyOrdersChart').getContext('2d');
                        const dailyOrdersChart = new Chart(ctxOrders, {
                            type: 'line',
                            data: {
                                labels: dates,
                                datasets: [{
                                    label: 'Daily Orders',
                                    data: orders,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching daily orders:', error));
            })
            .catch(error => console.error('Error fetching initial data:', error));
    });
</script>

</body>
</html>