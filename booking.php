<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>🌍 Tour & Travals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #001f3f 0%, #00d4ff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .booking-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .header-section {
            background: #001f3f;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
            border-color: #00d4ff;
        }
        .btn-proceed {
            background: #00d4ff;
            border: none;
            padding: 15px;
            font-weight: bold;
            border-radius: 10px;
            text-transform: uppercase;
            transition: 0.3s;
            color: #001f3f;
        }
        .btn-proceed:hover {
            background: #001f3f;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card booking-card">
                <div class="header-section">
                    <h3 class="m-0">📝 Enter Your Details</h3>
                    <small>Fill the form to confirm your reservation</small>
                </div>
                <div class="card-body p-4">
                    <form action="process.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Jatin Sharma" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Check-in</label>
                                <input type="date" name="checkin" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Check-out</label>
                                <input type="date" name="checkout" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-proceed w-100 mt-3">Confirm & Proceed to Payment →</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>