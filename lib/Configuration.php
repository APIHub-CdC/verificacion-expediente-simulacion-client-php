<?php
namespace CirculoDeCredito\VerificacionExpediente;

class Configuration
{
    private static $defaultConfiguration;
    
    protected $host = '';
    
    protected $userAgent = 'VerificacionExpedienteClientPhp-Codegen/1.0.0/php';
    
    protected $debug = false;
    
    protected $debugFile = 'php://output';
    
    protected $tempFolderPath;
    
    public function __construct()
    {
        $this->tempFolderPath = sys_get_temp_dir();
    }
    
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }
    
    public function getHost()
    {
        return $this->host;
    }
    
    public function setUserAgent($userAgent)
    {
        if (!is_string($userAgent)) {
            throw new \InvalidArgumentException('User-agent must be a string.');
        }
        $this->userAgent = $userAgent;
        return $this;
    }
    
    public function getUserAgent()
    {
        return $this->userAgent;
    }
    
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }
    
    public function getDebug()
    {
        return $this->debug;
    }
    
    public function setDebugFile($debugFile)
    {
        $this->debugFile = $debugFile;
        return $this;
    }
    
    public function getDebugFile()
    {
        return $this->debugFile;
    }
    
    public function setTempFolderPath($tempFolderPath)
    {
        $this->tempFolderPath = $tempFolderPath;
        return $this;
    }
    
    public function getTempFolderPath()
    {
        return $this->tempFolderPath;
    }
    
    public static function getDefaultConfiguration()
    {
        if (self::$defaultConfiguration === null) {
            self::$defaultConfiguration = new Configuration();
        }
        return self::$defaultConfiguration;
    }
    
    public static function setDefaultConfiguration(Configuration $config)
    {
        self::$defaultConfiguration = $config;
    }
    
    public static function toDebugReport()
    {
        $report  = 'PHP SDK (VerificacionExpedienteClientPhp\Client) Debug Report:' . PHP_EOL;
        $report .= '    OS: ' . php_uname() . PHP_EOL;
        $report .= '    PHP Version: ' . PHP_VERSION . PHP_EOL;
        $report .= '    OpenAPI Spec Version: 1.0.0' . PHP_EOL;
        $report .= '    Temp Folder Path: ' . self::getDefaultConfiguration()->getTempFolderPath() . PHP_EOL;
        return $report;
    }
    
    public function getApiKeyWithPrefix($apiKeyIdentifier)
    {
        $prefix = $this->getApiKeyPrefix($apiKeyIdentifier);
        $apiKey = $this->getApiKey($apiKeyIdentifier);
        if ($apiKey === null) {
            return null;
        }
        if ($prefix === null) {
            $keyWithPrefix = $apiKey;
        } else {
            $keyWithPrefix = $prefix . ' ' . $apiKey;
        }
        return $keyWithPrefix;
    }
}
