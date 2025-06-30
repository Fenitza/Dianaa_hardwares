<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Application</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eeeeee;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .email-header {
            background: #00457c;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .email-body {
            padding: 20px;
            text-align: left;
            line-height: 1.5;
        }
        .email-footer {
            text-align: center;
            padding: 10px 20px;
            font-size: 12px;
            color: #777777;
        }
        h1 {
            color: #00457c;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            padding: 10px;
            border: 1px solid #dddddd;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="email-container ">
    <div class="email-header align-center">
        <img src="https://dhw.co.in/images/logo/Diana_logo2.png" alt="Company Logo" class="logo">
        <h2>New Job Application</h2>
    </div>
    <div class="email-body">
        <h1>Hello!,</h1>
        <p>A new job application has been received with the following details:</p>

        <table>
            <tbody>
                <tr>
                    <td><strong>First Name</strong></td>
                    <td>{{ $first_name }}</td>
                </tr>
                <tr>
                    <td><strong>Last Name</strong></td>
                    <td>{{ $last_name }}</td>
                </tr>
                <tr>
                    <td><strong>Date of Birth</strong></td>
                    <td>{{ $dob }}</td>
                </tr>
                <tr>
                    <td><strong>Gender</strong></td>
                    <td>{{ $gender }}</td>
                </tr>
                <tr>
                    <td><strong>Address</strong></td>
                    <td>{{ $address }}</td>
                </tr>
                <tr>
                    <td><strong>Pincode</strong></td>
                    <td>{{ $pincode }}</td>
                </tr>
                <tr>
                    <td><strong>City</strong></td>
                    <td>{{ $city }}</td>
                </tr>
                <tr>
                    <td><strong>Mobile</strong></td>
                    <td>{{ $mobile }}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>{{ $email }}</td>
                </tr>
                <tr>
                    <td><strong>Total Experience</strong></td>
                    <td>{{ $total_exp }}</td>
                </tr>
                <tr>
                    <td><strong>Qualification</strong></td>
                    <td>{{ $qualification }}</td>
                </tr>
                <tr>
                    <td><strong>Present Job</strong></td>
                    <td>{{ $present_job }}</td>
                </tr>
                <tr>
                    <td><strong>Current CTC</strong></td>
                    <td>{{ $current_ctc }}</td>
                </tr>
                <tr>
                    <td><strong>Notice Period</strong></td>
                    <td>{{ $notice_period }}</td>
                </tr>
                <tr>
                    <td><strong>Expected CTC</strong></td>
                    <td>{{ $expected_ctc }}</td>
                </tr>
            </tbody>
        </table>

        <p style="margin-top: 20px;"><strong>Resume is attached with this email.</strong></p>
        <p>Please review the application and take the necessary steps.</p>
    </div>
    <div class="email-footer">
        This is an automated email. Please do not reply.
    </div>
</div>
</body>
</html>
