<?php

namespace Ddeboer\Imap;

class Parameters
{
    protected $parameters = [];
    
    public function __construct(array $parameters = [])
    {
        $this->add($parameters);
    }
    
    public function add(array $parameters = [])
    {
        foreach ($parameters as $parameter) {
            $key = strtolower($parameter->attribute);
            $value = $this->decode($parameter->value);
            $this->parameters[$key] = $value;
        }
    }
    
    public function get($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }
        
        return null;
    }
    
    protected function decode($value)
    {
        $decoded = '';
        $parts = imap_mime_header_decode($value);
        foreach ($parts as $part) {
            $decoded .= imap_utf8($part->text);
        }
        
        return $decoded;
    }
}
