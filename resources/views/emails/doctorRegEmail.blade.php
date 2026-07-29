<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to RCDHO</title>
</head>

<body style="margin:0;padding:30px;background:#f3f6fb;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #e5e7eb;box-shadow:0 12px 35px rgba(0,0,0,.08);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#4338CA,#7C3AED);padding:45px;text-align:center;color:#fff;">

                            <div style="font-size:55px;margin-bottom:10px;">
                                👨‍⚕️
                            </div>

                            <h1 style="margin:0;font-size:30px;font-weight:bold;">
                                Welcome to RCDHO
                            </h1>

                            <p style="margin:12px 0 0;font-size:16px;opacity:.95;">
                                Your Doctor Account has been Successfully Created
                            </p>

                        </td>
                    </tr>

                    <!-- Welcome -->
                    <tr>
                        <td style="padding:35px 40px;">

                            <h2 style="margin-top:0;color:#1F2937;">
                                Hello Dr. {{$request->name}},
                            </h2>

                            <p style="color:#6B7280;font-size:15px;line-height:28px;">
                                Congratulations! 🎉
                                <br><br>
                                Your registration has been completed successfully.
                                Below are your login credentials and profile information.
                                Please keep these details safe.
                            </p>

                        </td>
                    </tr>

                    <!-- Account Information -->
                    <tr>
                        <td style="padding:0 40px 25px;">

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border:1px solid #E5E7EB;border-radius:12px;overflow:hidden;">

                                <tr style="background:#EEF2FF;">
                                    <td colspan="2"
                                        style="padding:16px;font-size:18px;font-weight:bold;color:#4338CA;">
                                        Account Information
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;width:35%;">
                                        Full Name
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->name}}
                                    </td>
                                </tr>

                                <tr style="background:#FAFAFA;">
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        Email Address
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->email}}
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        Password
                                    </td>
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;color:#DC2626;font-weight:bold;">
                                        {{$planTextPasssword}}
                                    </td>
                                </tr>

                                <tr style="background:#FAFAFA;">
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        Mobile Number
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->phone}}
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        Doctor Stream
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->doctor_strime}}
                                    </td>
                                </tr>

                                <tr style="background:#FAFAFA;">
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        City
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->city}}
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        State
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->state}}
                                    </td>
                                </tr>

                                <tr style="background:#FAFAFA;">
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        Country
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->country}}
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="padding:14px;border-bottom:1px solid #F1F5F9;font-weight:bold;">
                                        Pin Code
                                    </td>
                                    <td style="padding:14px;border-bottom:1px solid #F1F5F9;">
                                        {{$request->pin_code}}
                                    </td>
                                </tr>

                                <tr style="background:#FAFAFA;">
                                    <td style="padding:14px;font-weight:bold;">
                                        Role
                                    </td>
                                    <td style="padding:14px;">
                                        {{ ucfirst($request->role) }}
                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                    <!-- Important Notice -->
                    <tr>
                        <td style="padding:0 40px;">

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#FFF7ED;border-left:5px solid #F97316;border-radius:10px;">
                                <tr>
                                    <td style="padding:20px;">

                                        <h3 style="margin:0;color:#C2410C;">
                                            🔒 Security Recommendation
                                        </h3>

                                        <p style="margin:12px 0 0;color:#7C2D12;line-height:26px;">
                                            Please keep your password confidential.
                                            Change your password immediately after your first login for better
                                            security.
                                        </p>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Button -->
                    <tr>
                        <td align="center" style="padding:40px;">

                            <a href="{{ route('login') }}"
                                style="background:#4F46E5;
                                       color:#ffffff;
                                       text-decoration:none;
                                       padding:16px 40px;
                                       border-radius:8px;
                                       font-size:16px;
                                       font-weight:bold;
                                       display:inline-block;
                                       box-shadow:0 8px 20px rgba(79,70,229,.35);">

                                Login to Your Account →
                            </a>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background:#111827;padding:35px;text-align:center;color:#D1D5DB;font-size:14px;">

                            <h3 style="margin:0;color:#ffffff;">
                                RCDHO
                            </h3>

                            <p style="margin:15px 0;line-height:24px;">
                                Thank you for choosing our healthcare platform.<br>
                                We are committed to providing secure and professional healthcare services.
                            </p>

                            <hr style="border:none;border-top:1px solid #374151;">

                            <p style="margin:18px 0 0;color:#9CA3AF;">
                                © {{ date('Y') }} RCDHO. All Rights Reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
