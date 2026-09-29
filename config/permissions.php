<?php

// Tabs a super_admin can grant to individual staff members.
// Doctors & Staff management and Settings are intentionally not delegable.
return [
    'patients' => [
        'label' => 'Patients',
        'icon' => 'fa-hospital-user',
        'route' => 'list.patient',
    ],
    'appointments' => [
        'label' => 'Appointments',
        'icon' => 'fa-calendar-check',
        'route' => 'listappoinment',
    ],
    'onsite_appointments' => [
        'label' => 'On-Site Appointments',
        'icon' => 'fa-globe',
        'route' => 'on_site_appointment',
    ],
    'rooms' => [
        'label' => 'Rooms',
        'icon' => 'fa-users',
        'route' => 'room.list',
    ],
    'analytics' => [
        'label' => 'Analytics',
        'icon' => 'fa-chart-line',
        'route' => 'analytics.disease',
    ],
    'reports' => [
        'label' => 'Reports',
        'icon' => 'fa-file-medical-alt',
        'route' => 'report.diabetesReport',
    ],
];
