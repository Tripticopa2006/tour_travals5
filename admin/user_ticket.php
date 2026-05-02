<?php
session_start();
include "admin/db.php"; 
// include "header.php"; // Apne header ko include karein

// 1. User authentication check
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// 2. Ticket ID check karein
if (!isset($_GET['id'])) {
    header("Location: my_tickets.php");
    exit();
}

$ticket_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = $_SESSION['user_id'];

// 3. Database se ticket details fetch karein
$query = "SELECT * FROM tickets WHERE id = '$ticket_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$ticket = mysqli_fetch_assoc($result);

if (!$ticket) {
    die("Ticket not found or unauthorized access!");
}

// Status ke hisaab se color set karein
$status_color = "";
switch ($ticket['status']) {
    case 'Open': $status_color = "warning"; break;
    case 'In Progress': $status_color = "primary"; break;
    case 'Closed': $status_color = "success"; break;
    default: $status_color = "secondary";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #<?php echo $ticket['id']; ?> - Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .ticket-container { margin-top: 50px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-header { background-color: #fff; border-bottom: 2px solid #eee; border-radius: 15px 15px 0 0 !important; padding: 20px; }
        .status-badge { padding: 8px 15px; font-size: 0.9rem; border-radius: 20px; }
        .chat-box { background-color: #fff; border-radius: 10px; padding: 20px; min-height: 200px; border: 1px solid #eee; }
        .btn-custom { border-radius: 10px; padding: 10px 20px; }
        
        /* PRINT STYLES */
        @media print {
            body * { visibility: hidden; }
            .card, .card * { visibility: visible; }
            .card { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container ticket-container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">Ticket #<?php echo $ticket['id']; ?></h3>
                        <p class="text-muted mb-0">Created on: <?php echo date('d M, Y', strtotime($ticket['created_at'])); ?></p>
                    </div>
                    <span class="badge bg-<?php echo $status_color; ?> status-badge text-uppercase">
                        <?php echo $ticket['status']; ?>
                    </span>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary">Subject: <?php echo htmlspecialchars($ticket['subject']); ?></h5>
                    <p class="card-text text-secondary mt-3">
                        <strong>Description:</strong><br>
                        <?php echo nl2br(htmlspecialchars($ticket['description'])); ?>
                    </p>
                    
                    <hr class="my-4">
                    
                    <h5>Conversation</h5>
                    <div class="chat-box mb-3">
                        <p class="text-muted text-center pt-5">No replies yet.</p>
                    </div>
                    
                    <form action="add_reply.php" method="POST" class="no-print">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                        <div class="mb-3">
                            <textarea name="reply" class="form-control" rows="3" placeholder="Type your reply here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-custom w-100">Send Reply</button>
                    </form>
                </div>
                
                <div class="card-footer text-center bg-white border-top-0 pb-4">
                    <a href="my_tickets.php" class="btn btn-outline-secondary btn-sm no-print">Back to Tickets</a>
                    <button onclick="window.print()" class="btn btn-success btn-sm no-print">Print / Save as PDF</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>