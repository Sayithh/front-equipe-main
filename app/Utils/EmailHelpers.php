<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class EmailHelpers
{
    public static function sendEmail($to, $subject, $view, $data = [], $attachmentPath = null)
{
    try {
        Mail::send($view, $data, function ($message) use ($to, $subject, $attachmentPath) {
            $message->to($to)
                    ->subject($subject);

            // Ajout de la pièce jointe si elle existe
            if ($attachmentPath) {
                $message->attach($attachmentPath);
            }
        });
    } catch (\Exception $e) {
        Log::error('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
    }
}}
