<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>BookHaven</title>
    <link rel="stylesheet" href="adminUser.css" />
    <link rel="icon" href="media/BH_Logo.png" />
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

    <?php  
    include "dbConn.php"; 
    $sql = "SELECT * FROM users"; 
    $result = $conn->query($sql); 
    ?> 

    <div class="container"> 
        <h2>Users</h2> 

        <table class="table"> 
            <thead> 
                <tr> 
                    <th>User ID</th> 
                    <th>User Name</th> 
                    <th>Name</th> 
                    <th>Email</th> 
                    <th>Address</th> 
                    <th>Password</th> 
                    <th>Phone Number</th> 
                    <th>Access Level</th> 
                    <th>Actions</th> 
                </tr> 
            </thead> 

            <tbody>  
                <?php 
                if ($result->num_rows > 0) { 
                    while ($row = $result->fetch_assoc()) { 
                ?> 
                        <tr> 
                            <td><?php echo $row['user_id']; ?></td> 
                            <td><?php echo $row['user_username']; ?></td> 
                            <td><?php echo $row['user_fullname']; ?></td> 
                            <td><?php echo $row['user_email']; ?></td> 
                            <td><?php echo $row['user_address']; ?></td> 
                            <td><?php echo $row['user_password']; ?></td> 
                            <td><?php echo $row['user_phoneNo']; ?></td> 
                            <td><?php echo $row['user_al']; ?></td> 
                            <td> 
                                <form action="adminUserEdit.php" method="get"> 
                                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>"> 
                                    <button type="submit" class="btn btn-info" name="edit">Edit</button> 
                                </form> 

                                <form action="adminUserDelete.php" method="get"> 
                                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>"> 
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button> 
                                </form> 
                            </td> 
                        </tr> 
                <?php       
                    } 
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
