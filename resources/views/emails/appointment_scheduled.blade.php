<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Appointment Confirmed - RCDHO Clinic</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=1">
    <style type="text/css">
        body, table, td, tr, p {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            background-color: #ffffff;
            color: #112640;
            line-height: 1.5;
        }
        @media screen and (max-width: 640px) {
            .mobile-p {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            .stack-col {
                display: block !important;
                width: 100% !important;
                padding-right: 0 !important;
                margin-bottom: 20px !important;
            }
            .stack-col-last {
                margin-bottom: 0 !important;
            }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#ffffff;width:100%!important;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;">

    <!-- 1. Header Bar (Full Screen 100% Edge-to-Edge) -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;background-color:#12343b;border-collapse:collapse;">
        <tr>
            <td class="mobile-p" style="padding:24px 35px;text-align:center;">
                <div style="display:inline-block;background:linear-gradient(135deg,#0f766e,#2563eb);color:#ffffff;font-size:20px;font-weight:800;width:40px;height:40px;line-height:40px;border-radius:50%;text-align:center;margin-bottom:8px;">
                    R
                </div>
                <div style="font-size:20px;font-weight:800;letter-spacing:0.5px;color:#ffffff;line-height:1.2;">
                    RCDHO
                </div>
                <div style="font-size:13px;color:#f59e0b;font-weight:600;margin-top:2px;">
                    DrMukherjeeS Clinic Pvt. Ltd.
                </div>
                <div style="font-size:12px;color:#cbd5e1;margin-top:2px;letter-spacing:0.3px;">
                    Research Centre for Diabetes, Hypertension and Obesity
                </div>
            </td>
        </tr>
    </table>

    <!-- 2. Greeting & Confirmation Heading (Full Screen 100%) -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;background-color:#ffffff;border-collapse:collapse;">
        <tr>
            <td class="mobile-p" style="padding:35px 35px 15px;text-align:center;">
                <h2 style="margin:0;font-size:24px;font-weight:700;color:#12343b;line-height:1.3;">
                    Hi {{ $appointment->patient_name }},
                </h2>
                <p style="margin:10px 0 0;font-size:15px;color:#475569;line-height:1.6;">
                    Your booking at <strong>RCDHO Clinic</strong> is confirmed. Please find the consultation details below:
                </p>
            </td>
        </tr>
    </table>

    <!-- 3. Featured Details Section (Full Screen 100% Background Strip) -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;background-color:#f4fbf8;border-top:1px solid #dff5ed;border-bottom:1px solid #dff5ed;border-collapse:collapse;">
        <tr>
            <td class="mobile-p" style="padding:32px 35px;">
                <div style="font-size:19px;font-weight:800;color:#0f766e;text-align:center;margin-bottom:20px;letter-spacing:-0.2px;">
                    Consultation Appointment
                </div>

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;border-collapse:collapse;">
                    
                    <!-- Scheduled Date -->
                    <tr>
                        <td style="padding:11px 0;font-size:14px;color:#475569;width:35%;border-bottom:1px solid #e2ece8;">
                            <strong>Date:</strong>
                        </td>
                        <td style="padding:11px 0;font-size:16px;font-weight:800;color:#0f766e;border-bottom:1px solid #e2ece8;">
                            {{ \Carbon\Carbon::parse($appointment->appointment_scheduled_date)->format('l, d F Y') }}
                        </td>
                    </tr>

                    <!-- Patient Name -->
                    <tr>
                        <td style="padding:11px 0;font-size:14px;color:#475569;border-bottom:1px solid #e2ece8;">
                            <strong>Patient Name:</strong>
                        </td>
                        <td style="padding:11px 0;font-size:15px;font-weight:600;color:#12343b;border-bottom:1px solid #e2ece8;">
                            {{ $appointment->patient_name }}
                        </td>
                    </tr>

                    @if(!empty($appointment->father_name))
                    <!-- Father's Name -->
                    <tr>
                        <td style="padding:11px 0;font-size:14px;color:#475569;border-bottom:1px solid #e2ece8;">
                            <strong>Father's Name:</strong>
                        </td>
                        <td style="padding:11px 0;font-size:14px;color:#12343b;border-bottom:1px solid #e2ece8;">
                            {{ $appointment->father_name }}
                        </td>
                    </tr>
                    @endif

                    @if(!empty($appointment->age))
                    <!-- Age -->
                    <tr>
                        <td style="padding:11px 0;font-size:14px;color:#475569;border-bottom:1px solid #e2ece8;">
                            <strong>Age:</strong>
                        </td>
                        <td style="padding:11px 0;font-size:14px;color:#12343b;border-bottom:1px solid #e2ece8;">
                            {{ $appointment->age }} Years
                        </td>
                    </tr>
                    @endif

                    <!-- Visit Type -->
                    <tr>
                        <td style="padding:11px 0;font-size:14px;color:#475569;border-bottom:1px solid #e2ece8;">
                            <strong>Visit Type:</strong>
                        </td>
                        <td style="padding:11px 0;font-size:14px;font-weight:600;color:#12343b;border-bottom:1px solid #e2ece8;">
                            {{ $appointment->patient_type ?? 'General Consultation' }}
                        </td>
                    </tr>

                    <!-- Mobile -->
                    <tr>
                        <td style="padding:11px 0;font-size:14px;color:#475569;border-bottom:1px solid #e2ece8;">
                            <strong>Mobile:</strong>
                        </td>
                        <td style="padding:11px 0;font-size:14px;color:#12343b;font-family:monospace;border-bottom:1px solid #e2ece8;">
                            {{ $appointment->phone ?? 'N/A' }}
                        </td>
                    </tr>

                    @if(!empty($appointment->address))
                    <!-- Address -->
                    <tr>
                        <td style="padding:11px 0;font-size:14px;color:#475569;border-bottom:1px solid #e2ece8;">
                            <strong>Address:</strong>
                        </td>
                        <td style="padding:11px 0;font-size:14px;color:#12343b;border-bottom:1px solid #e2ece8;">
                            {{ $appointment->address }}
                        </td>
                    </tr>
                    @endif

                </table>

                <!-- Helpline Call Button -->
                <div style="margin-top:25px;text-align:center;">
                    <a href="tel:+918002268003" style="display:inline-block;background-color:#0f766e;color:#ffffff;font-size:14px;font-weight:700;padding:12px 30px;border-radius:8px;text-decoration:none;letter-spacing:0.3px;">
                        Helpline: 8002268003
                    </a>
                </div>
            </td>
        </tr>
    </table>

    <!-- 4. Need to Make Changes / Advisory Block (Full Screen 100%) -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;background-color:#ffffff;border-collapse:collapse;">
        <tr>
            <td class="mobile-p" style="padding:30px 35px 35px;text-align:center;">
                <div style="font-size:16px;font-weight:700;color:#12343b;">
                    Need to make changes to your appointment?
                </div>
                <div style="font-size:14px;color:#64748b;margin-top:6px;line-height:1.6;">
                    Please arrive 15 minutes early and carry past prescription slips or laboratory reports.<br>
                    To reschedule, contact clinic reception at <strong>8002268003</strong> or email <strong>drmukherjees@gmail.com</strong>.
                </div>
            </td>
        </tr>
    </table>

    <!-- 5. Two-Column Full Screen Dark Footer (100% Edge-to-Edge #12343b) -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;background-color:#12343b;color:#ffffff;border-collapse:collapse;">
        <tr>
            <td class="mobile-p" style="padding:36px 35px 28px;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;border-collapse:collapse;">
                    <tr>
                        
                        <!-- Left Column: About Clinic -->
                        <td valign="top" width="50%" class="stack-col" style="padding-right:30px;">
                            <div style="font-size:17px;font-weight:800;color:#ffffff;margin-bottom:8px;">
                                RCDHO Clinic
                            </div>
                            <div style="font-size:13px;color:#cbd5e1;line-height:1.6;">
                                DrMukherjeeS Clinic Pvt. Ltd. provides structured diabetes, BP, obesity, metabolic, ultrasound, and lifestyle care in Bihar.
                            </div>
                            <div style="font-size:12px;color:#f59e0b;font-weight:600;margin-top:10px;">
                                Prescription Validity: 15 Days | Sunday Closed
                            </div>
                        </td>

                        <!-- Right Column: Clinic Locations & Contact -->
                        <td valign="top" width="50%" class="stack-col stack-col-last">
                            <div style="font-size:16px;font-weight:800;color:#f59e0b;margin-bottom:8px;">
                                Clinic Locations
                            </div>
                            <div style="font-size:13px;color:#cbd5e1;line-height:1.6;">
                                <strong>Samastipur:</strong> Bengali Tola, Samastipur - 848101<br>
                                Phone: 8002268003<br>
                                Email: drmukherjees@gmail.com
                            </div>
                        </td>

                    </tr>

                    <!-- Bottom Divider & Copyright -->
                    <tr>
                        <td colspan="2" style="border-top:1px solid rgba(255,255,255,0.15);padding-top:20px;margin-top:20px;text-align:center;">
                            <div style="font-size:11px;color:#94a3b8;line-height:1.5;">
                                &copy; {{ date('Y') }} RCDHO (DrMukherjeeS Clinic Pvt. Ltd.). All rights reserved.
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
