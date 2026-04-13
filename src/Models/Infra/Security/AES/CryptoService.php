<?php

namespace src\Models\Infra\Security\AES;

define('CRIP_KEY', hash('sha256', 'SENHA SUPER ESPECIAL COM CHARCTERES maiusculos e minusculos 1 numero e l3tr@s')); // senha temporaria para teste do sistema.

class CryptoService
{
    private string $key; 
    private string $chiper;

    public function __construct()
    {
        $this->chiper = "aes-256-gcm";
        $this->key = CRIP_KEY;
    }

   public function encrypt(string $texto): array
    {
        $ivlen = openssl_cipher_iv_length($this->chiper);
        $iv = random_bytes($ivlen);

        $ciphertext = openssl_encrypt($texto,$this->chiper,$this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return [
            'ciphertext' => base64_encode($ciphertext),
            'iv' => base64_encode($iv),
            'tag' => base64_encode($tag)
        ];
    }

    public function decrypt(array $colunm): array|string|false{
        $output = array();
        foreach ($colunm as $key => $value) {
            array_push($output, $this->decryptMethod($colunm[$key]));
        }
        return $output;
    }

    private function decryptMethod(array $colunm): array|false{
        try{
            // echo "<pre>";
            // print_r($colunm);

            
            $ciphertext = base64_decode($colunm['anotacao'] ?? null);
            $iv = base64_decode($colunm['IV'] ?? null);
            $tag = base64_decode($colunm['tag'] ?? null);
                
            $texto = openssl_decrypt(
                $ciphertext,
                $this->chiper,
                $this->key,
                OPENSSL_RAW_DATA,
                $iv,
                $tag
            );
                $colunm['anotacao'] = $texto;
            return $colunm;
        }catch (\Exception $e) {
                echo "Erro na descriptografia: " . $e->getMessage();
            return false;
        }
    }
}
