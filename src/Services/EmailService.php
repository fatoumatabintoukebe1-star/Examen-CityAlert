<?php
namespace App\Services;

require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private PHPMailer $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'fatoumatabintoukebe1@gmail.com'; // ← ton email
        $this->mail->Password   = 'ehkc zlno wbxw welq';    // ← le code 16 caractères
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
        $this->mail->CharSet    = 'UTF-8';
        $this->mail->setFrom('fatoumatabintoukebe1@gmail.com', 'CityAlert');
    }

    public function envoyerChangementStatut(
        string $destinataire,
        string $nomCitoyen,
        string $titreSig,
        string $ancienStatut,
        string $nouveauStatut,
        string $commentaire = ''
    ): bool {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($destinataire, $nomCitoyen);
            $this->mail->isHTML(true);
            $this->mail->Subject = "CityAlert — Votre signalement a été mis à jour";
            $this->mail->Body = "
                <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto'>
                    <div style='background:#1E3A5F;padding:20px;text-align:center'>
                        <h1 style='color:#fff;margin:0'>🏙️ CityAlert</h1>
                    </div>
                    <div style='padding:30px;background:#f8fafc'>
                        <h2 style='color:#1E3A5F'>Mise à jour de votre signalement</h2>
                        <p>Bonjour <b>{$nomCitoyen}</b>,</p>
                        <p>Votre signalement <b>« {$titreSig} »</b> a été mis à jour.</p>
                        <div style='background:#fff;padding:20px;border-radius:10px;
                                    border-left:4px solid #2563EB;margin:20px 0'>
                            <p><b>Ancien statut :</b> {$ancienStatut}</p>
                            <p><b>Nouveau statut :</b> 
                                <span style='color:#2563EB;font-weight:bold'>
                                    {$nouveauStatut}
                                </span>
                            </p>
                            " . ($commentaire ? "<p><b>Remarque :</b> {$commentaire}</p>" : "") . "
                        </div>
                        <p>Connectez-vous sur CityAlert pour plus de détails.</p>
                    </div>
                    <div style='background:#1E3A5F;padding:15px;text-align:center'>
                        <p style='color:#94A3B8;margin:0;font-size:.85rem'>
                            &copy; " . date('Y') . " CityAlert — ISEP Diamniadio
                        </p>
                    </div>
                </div>
            ";
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Email error: ' . $e->getMessage());
            return false;
        }
    }
}