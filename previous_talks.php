<?php
/*
Template Name: Events
*/
?>

<?php
$apiUrl = 'https://ims.iiit.ac.in/research_apis.php?typ=getEvents';

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$json_string = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
    exit;
}

curl_close($ch);

$data = json_decode($json_string, true);

if ($data === null) {
    echo 'Error decoding JSON';
    exit;
}

$currentDate = date('Y-m-d');
$currentYear = date('Y');
$upcomingEvents = [];
$previousEvents = [];

foreach ($data as $event) {
    $eventStartDate = $event['startdate'];
    $eventEndDate = $event['enddate'];

    if ($eventStartDate >= $currentDate && $eventEndDate >= $currentDate && date('Y', strtotime($eventStartDate)) == $currentYear) {
        $upcomingEvents[] = $event;
    } else {
        $previousEvents[] = $event;
    }
}

$perPage = 4;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$totalUpcomingEvents = count($upcomingEvents);
$totalPreviousEvents = count($previousEvents);

$upcomingEvents = array_slice($upcomingEvents, ($page - 1) * $perPage, $perPage);
$previousEvents = array_slice($previousEvents, ($page - 1) * $perPage, $perPage);

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

    <title>Student Template</title>

    <link href="https://fonts.googleapis.com/css?family=Cinzel+Decorative&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
    <div class="container">
        <!-- Upcoming Events -->
        <div class="row">
            <div class="col-12 m-3 mb-3">
                <h2>Upcoming Events</h2>
                <br>
               <div class="row">
                   <?php
foreach ($upcomingEvents as $event) {
    $dateComponents = explode('-', $event['displaydate']);
    [$month, $day] = $dateComponents;

    // Check if photo is null or empty
    $photoSrc = (!empty($event['photo']) ? htmlspecialchars($event['photo']) : 'https://i.postimg.cc/qRHbHJQP/thumbnail-events.jpg');

    echo '
    <div class="card col-lg-3 col-md-6 col-sm-12" style="background-color:#ECECEC; height:auto;">
        <a href="' . $event['url'] . '">
            <div style="height: 200px; overflow: hidden;"> <!-- Set a fixed height for the image container -->
                <img src="' . $photoSrc . '" class="img-fluid" alt="Event Image" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </a>
        <div>
            <p class="date-content text-md-center">' . $month . '<br>' . $day . '</p>
        </div>
        <div class="info-content">
            <p style="font-size:16px; font-weight:bold; color:#0d264a">' . $event['title'] . '</p>
            <p style="font-weight:500; font-size:15px;">' . $event['description'] . '</p>
        </div>
    </div>';
}
?>
 <div class="modal fade" id="eventModalupcoming<?= $index ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalupcoming<?= $index ?>"><?= $event['title'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="info-content">
                    <div style="align-items: center; margin-top: 50px;">
                        <p style="color:#0d264a; font-weight: bold;"><?= $event['speaker'] ?></p>
                    </div>
                    <div style="display: flex; align-items: center; margin-top: 10px;">
                        <img src="https://cdn-icons-png.flaticon.com/128/10691/10691802.png" style="width: 15px; height: 15px; margin-right: 5px;">
                        <p class="date-content text-md-center" style="margin-right: 10px;"><?= $event['displaydate'] ?></p>
                        <span style="font-size: 12px; font-weight: bold;"><?= $event['venue'] ?></span>
                        <span style="font-size: 12px; font-weight: bold;">&nbsp;at&nbsp; <?= $event['time'] ?></span>
                    </div>
                    
                    <?php if (!empty($event['bio'])): ?>
                       <span> <p class="description1" style="font-weight:400; font-size:15px;"><b>Bio: &nbsp;</b><?= $event['bio'] ?></p></span>
                    <?php endif; ?>

                    <?php if (!empty($event['description'])): ?>
                    
                        <span><p class="description1" style="font-weight:400; font-size:15px;"><b>Description: &nbsp;</b><?= $event['description'] ?></p></span>
                    <?php endif; ?>

                    <?php if (!empty($event['abstract'])): ?>
                   
                       <span> <p class="description1" style="font-weight:400; font-size:15px;"><b>Abstract: &nbsp;</b><?= $event['abstract'] ?></p></span>
                    <?php endif; ?>

                    <img src="<?= $event['photo'] ?>" class="img-fluid" alt="Event Image">
                </div>
            </div>
        </div>
    </div>
</div>
               </div>
               <!-- Pagination for Upcoming Events -->
               <div class="row">
                   <div class="col-12">
                       <?php
                       $pagination_upcoming = paginate_links(array(
                           'base' => get_pagenum_link(1) . '%_%',
                           'format' => '?page=%#%',
                           'current' => $page,
                           'total' => ceil($totalUpcomingEvents / $perPage),
                           'prev_text' => __('Previous'),
                           'next_text' => __('Next'),
                       ));

                       if ($pagination_upcoming) {
                           echo '<div class="pagination-container">' . $pagination_upcoming . '</div>';
                       }
                       ?>
                   </div>
               </div>
           </div>
</div>
        <!-- Previous Events -->
        <div class="row">
            <div class="col-12 m-3 mb-3">
                <h2>Previous Events</h2>
                <br>
                <div class="row">
                                 

                </div>
                <!-- Pagination for Previous Events -->
                <div class="row">
                    <div class="col-12">
                        <?php
                        $pagination_previous = paginate_links(array(
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => '?page=%#%',
                            'current' => $page,
                            'total' => ceil($totalPreviousEvents / $perPage),
                            'prev_text' => __('Previous'),
                            'next_text' => __('Next'),
                        ));

                        if ($pagination_previous) {
                            echo '<div class="pagination" style="margin:10px;background-color:white;color:#0d264a;font-weight:bold;">' . $pagination_previous . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
