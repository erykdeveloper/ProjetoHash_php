<?php
// src/Service/hashManagerService.php
namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;

class hashManagerService
{
    public function generate($length = 8): string
    {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
    }
    #[ArrayShape(["hash" => "string", "key" => "string", "attemps" => "int"])]
    public function search(string $string): array {
        $string8CharKEY = $this->generate();
        $stringSaveFirstKey = $string8CharKEY;
        for ($i = 1; ;$i++) {
            $string8CharKEY = md5($string.$string8CharKEY);
            $prefix = substr($string8CharKEY, 0, 4);
            $attemps = $i;
            if ($prefix === "0000") {
                $hashFound = $string8CharKEY;
                break;
            }
        }
        return array(
            "hash" => $hashFound,
            "key" => $stringSaveFirstKey,
            "attemps" => $attemps
        );
    }
}
