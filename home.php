<?php
/*
Template Name: Home
*/
?>
<?php get_header() ?>
<?php

$api_url = "https://ims.iiit.ac.in/research_apis.php?typ=getNews";
$api_url1="https://ims.iiit.ac.in/research_apis.php?typ=getAnnouncements";
// Create a stream context with SSL options
$sslContext = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

// Use the stream context when fetching data
$response = file_get_contents($api_url, false, $sslContext);

$data = json_decode($response, true);
$response1 = file_get_contents($api_url1, false, $sslContext);

$data1 = json_decode($response1, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Aleo:wght@900&display=swap" rel="stylesheet">
    <!-- Include your preferred CSS framework or styles for accordion here -->
    <!-- Include your preferred CSS framework or styles for accordion here -->
    <style>
          .img-fluid{
            width: 100%;
            height:150px;
        }
        .paper_info, .time{
            color:grey;
            font-size:12px;
            font-weight:bold;
        }
        .title{
            font-size:15px;
            font-weight:500;
            margin-bottom: 5px;
        }
        .content{
            font-size:15px;
            margin-top: -5px; /* Reduced margin top */
    margin-bottom: 5px
        }
        .list-announcement{
            list-style:none;
        }
        .heading{
            background-color:#E6C08F;
            font-weight:bold;
            font-size:20px;
            padding:5px;
            text-align: center;
            width:100%;
        }
        .box-2{
            border:1px solid lightgray;
        }
        
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
/* Add animation keyframes */
@keyframes slideIn {
    0% {
        opacity: 0;
        transform: translateY(100%);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Apply animation to the caption */
.animated-slide {
    animation: slideIn 0.5s ease-in-out;
}

    </style>
</head>

<body>
    <div class="container">
    <div class="row m-4">
    <div class="col-md-8 mb-4 mb-md-0 position-relative"> <!-- Added margin bottom for spacing -->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" style="height: 410px;"> <!-- Adjust the height as needed -->
            <div class="carousel-item active">
                <img class="d-block w-100 h-100" src="https://research.iiit.ac.in/wp-content/uploads/2024/02/IIIT-Hyderabad-Seat-Matrix_cleanup.png" alt="First slide">
                <div class="carousel-caption d-flex justify-content-center align-items-center">
                    <div class="text-center animated-slide">
                        <h5>Research Center of IIIT Hyderabad</h5>
                        <p>Research Center of IIIT Hyderabad, all different centers in the international institute of information and technology</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="https://research.iiit.ac.in/wp-content/uploads/2024/01/5g-network-smart-city-background-technology-scaled.jpg" alt="Second slide">
                <div class="carousel-caption d-flex justify-content-center align-items-center">
                    <div class="text-center animated-slide">
                        <h5>5G Lab Award </h5>
                        <p>The 7th edition of the India Mobile Congress (IMC) witnessed a remarkable moment as the Honorable Prime Minister, Sri Narendra Modi, virtually presented IIIT Hyderabad with the prestigious 5G Lab Award.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="https://research.iiit.ac.in/wp-content/uploads/2024/02/DigLib1.png" alt="Third slide">
                <div class="carousel-caption d-flex justify-content-center align-items-center">
                    <div class="text-center animated-slide">
                        <h5>National Digital Library of India</h5>
                        <p>The National Digital Library of India (NDLI) has recognised IIITH as one of the best performing NDLI clubs in Telangana</p>
                    </div>
                </div>
            </div>
        </div>
                        
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

            <div class="col-md-4">
    <!-- First image with text -->
    <div class="position-relative">
        <img src="https://research.iiit.ac.in/wp-content/uploads/2024/02/Screenshot-2024-02-07-145330_cleanup.png" class="img-fluid mb-4" alt="First image" style="height: 192px;"> <!-- Added height -->
        <div class="centered" style="color: white;">
            <h5 style="font-size:30px;font-weight:bold;">Events</h5>
        </div>
    </div>
    
    <!-- Second image with text -->
    <div class="position-relative">
        <img src="https://research.iiit.ac.in/wp-content/uploads/2024/02/images-6_cleanup.png" class="img-fluid" alt="Second image" style="height: 192px;"> <!-- Added height -->
        <div class="centered" style="color: white;">
            <h5 style="font-size:30px;font-weight:bold;">Talks</h5>
        </div>
    </div>
</div>

        </div>
    
        <div class="row m-4">
            <!-- News -->
            <div class="col-md-8">
                <h4 class="heading w-100">News</h4>
                <?php
                // Check if data is available and is an array
                if ($data && is_array($data)) {
                    // Loop through each item in the data array
                    foreach ($data as $item) {
                        // Set a default image if no image is provided
                        $image = !empty($item['photo']) ? $item['photo'] : 'https://i.postimg.cc/9MwGHx97/news-default-big.png';
                        // Truncate description if it's too long
                        $description = strlen($item['description']) > 100 ? substr($item['description'], 0, 100) . "..." : $item['description'];
                        // Display the news item
                        echo '<div class="row mb-4">';
                        echo '<div class="col-md-5">';
                        echo '<img src="' . $image . '" class="img-fluid" alt="Image">';
                        echo '</div>';
                        echo '<div class="col-md-7">';
                        echo '<p class="paper_info">' . $item['paper'] . '</p>';
                        echo '<p class="title">'.$item['title'].'</p>';
                        echo '<p class="content">' . $description . '</p>';
                        echo '<p class="time">'.$item['time'].'</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    // Display a message if no data is available
                    echo '<p>No news available.</p>';
                }
                ?>
            </div>
            <!-- Announcement -->
            <div class="col-md-4 box-2">
                <h4 class="heading w-100">Announcements</h4>
                <ul class="list-announcement">
                    <li>International Institute of Information Technology Hyderabad</li>
                    <li>International Institute of Information Technology Hyderabad</li>
                    <li>International Institute of Information Technology Hyderabad</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>

<?php get_footer() ?>