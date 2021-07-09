<?php

/**
 * Class EncryptDecrypt
 */
class EncryptDecrypt
{
    private string $encrypt_method = "AES-256-CBC";
    private string $secret_key;
    private string $secret_iv;
    private string $key;
    private string $iv;

    /**
     * EncryptDecrypt constructor.
     * @param string $secret_key_input
     */
    public function __construct(string $secret_key_input)
    {
        $this->secret_key = $secret_key_input;
        $this->secret_iv = md5($this->secret_key);
        $this->key = hash('sha256', $this->secret_key);
        $this->iv = substr(hash('sha256', $this->secret_iv), 0, 16);
    }

    /**
     * @param string $string
     * @return string
     */
    public function encrypt(string $string): string
    {
        return base64_encode(openssl_encrypt($string, $this->encrypt_method, $this->key, 0, $this->iv));
    }

    /**
     * @param string $encrypted_string
     * @return string|false
     */
    public function decrypt(string $encrypted_string)
    {
        return openssl_decrypt(base64_decode($encrypted_string), $this->encrypt_method, $this->key, 0, $this->iv);
    }
}

$encrypt_decrypt = new EncryptDecrypt('SECRET_KEY');
$encrypted = $encrypt_decrypt->encrypt('mynameisBVK');
echo "\nEncrypted: " . $encrypted;
echo "\nDecrypted: " . $encrypt_decrypt->decrypt($encrypted);
