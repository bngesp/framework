<?php

declare(strict_types=1);

namespace Bow\Http\Client;

use CurlHandle;

class HttpClient
{
    /**
     * The attach file collection
     *
     * @var array
     */
    private $attach = [];

    /**
     * The curl instance
     *
     * @var CurlHandle
     */
    private ?CurlHandle $ch = null;

    /**
     * The base url
     *
     * @var string|null
     */
    private ?string $base_url = null;

    /**
     * HttpClient Constructor.
     *
     * @param string $base_url
     * @return void
     */
    public function __construct(?string $base_url = null)
    {
        if (!function_exists('curl_init')) {
            throw new \BadFunctionCallException('cURL php is require.');
        }

        if (!is_null($base_url)) {
            $this->base_url = rtrim($base_url, "/");
        }
    }

    /**
     * Set the base url
     *
     * @param string $url
     * @return void
     */
    public function setBaseUrl(string $url): void
    {
        $this->base_url = rtrim($url, "/");
    }

    /**
     * Make get requete
     *
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function get(string $url, array $data = []): Response
    {
        if (count($data) > 0) {
            $params = http_build_query($data);
            $url . "?" . $params;
        }

        $this->init($url);
        $this->applyCommonOptions();

        curl_setopt($this->ch, CURLOPT_HTTPGET, true);

        $content = $this->execute();

        return new Response($this->ch, $content);
    }

    /**
     * make post requete
     *
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function post(string $url, array $data = []): Response
    {
        $this->init($url);

        if (!empty($this->attach)) {
            curl_setopt($this->ch, CURLOPT_UPLOAD, true);

            foreach ($this->attach as $key => $attach) {
                $this->attach[$key] = '@' . ltrim('@', $attach);
            }

            $data = array_merge($this->attach, $data);
        }

        $this->addFields($data);
        $this->applyCommonOptions();

        curl_setopt($this->ch, CURLOPT_POST, true);

        $content = $this->execute();

        return new Response($this->ch, $content);
    }

    /**
     * Make put requete
     *
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function put(string $url, array $data = []): Response
    {
        $this->init($url);
        $this->addFields($data);
        $this->applyCommonOptions();

        curl_setopt($this->ch, CURLOPT_PUT, true);

        $content = $this->execute();

        return new Response($this->ch, $content);
    }

    /**
     * Make put requete
     *
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function delete(string $url, array $data = []): Response
    {
        $this->init($url);
        $this->addFields($data);
        $this->applyCommonOptions();

        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $content = $this->execute();

        return new Response($this->ch, $content);
    }

    /**
     * Attach new file
     *
     * @param string $attach
     * @return array
     */
    public function addAttach(string|array $attach): array
    {
        return $this->attach = (array) $attach;
    }

    /**
     * Add aditionnal header
     *
     * @param array $headers
     * @return HttpClient
     */
    public function addHeaders(array $headers): HttpClient
    {
        $data = [];

        foreach ($headers as $key => $value) {
            $data[] = $key . ': ' . $value;
        }

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $data);

        return $this;
    }

    /**
     * Reset alway connection
     *
     * @param string $url
     * @return void
     */
    private function init(string $url): void
    {
        if (is_null($this->base_url)) {
            $url = $this->base_url . "/" . trim($url, "/");
        }

        $this->ch = curl_init(trim($url, "/"));
    }

    /**
     * Add fields
     *
     * @param array $data
     * @return void
     */
    private function addFields(array $data): void
    {
        if (count($data) > 0) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
    }

    /**
     * Close connection
     *
     * @return void
     */
    private function close(): void
    {
        curl_close($this->ch);
    }

    /**
     * Execute request
     *
     * @return string
     * @throws \Exception
     */
    private function execute(): string
    {
        $content = curl_exec($this->ch);
        $errno = curl_errno($this->ch);

        $this->close();

        if ($content === false) {
            throw new \Exception(curl_strerror($errno));
        }

        return $content;
    }

    /**
     * Set Curl CURLOPT_RETURNTRANSFER option
     *
     * @return bool
     */
    private function applyCommonOptions()
    {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
    }
}
