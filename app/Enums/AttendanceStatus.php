<?php
namespace App\Enums;

enum AttendanceStatus:int {
    case notgoing = 1;
}

// if ($request->status == 1) {
//     $status = 'notgoing';
// } elseif ($request->status == 2) {
//     $status = 'waiting';
// } elseif ($request->status == 3) {
//     $status = 'toHome';
// } elseif ($request->status == 4) {
//     $status = 'toSchool';
// } elseif ($request->status == 5) {
//     $status = 'en-route';
// } elseif ($request->status == 6) {
//     $status = 'dropped off';
// } elseif ($request->status == 7) {
//     $status = 'absent';
// }