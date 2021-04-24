<?php

namespace Sim\I18n\Traits;

use Sim\I18n\ISOLanguageCodes;
use Sim\I18n\Utils\ArrayUtil;

trait TraitTranslate
{
    /**
     * @var array $resolved_files
     */
    protected $resolved_files = [];

    /**
     * @var string $translate_dir
     */
    protected $translate_dir = '';

    /**
     * @var string $translated_file
     */
    protected $translated_file = ISOLanguageCodes::LANGUAGE_ENGLISH . '.php';

    /**
     * @var string $language
     */
    protected $language = ISOLanguageCodes::LANGUAGE_ENGLISH;

    /**
     * @var bool $is_rtl
     */
    protected $is_rtl = false;

    /**
     * {@inheritdoc}
     */
    public function createLanguageFile(string $language, string $directory)
    {
        $directory = $this->changeSlashes($directory);

        $res = true;
        // create language directory is not exists
        if (!\file_exists($directory)) {
            $res = \mkdir($directory, 0774); // Creates the directory
        }

        if ($res) {
            // create language file
            $filename = $directory . DIRECTORY_SEPARATOR . $language . '.php';
            if (!\file_exists($filename)) {
                // open/create file for writing
                $file = \fopen($filename, "w") or die("Unable to open file!");
                // add empty content to it
                $txt = "<?php\n\n";
                \fwrite($file, $txt);
                $txt = "return [\n\n";
                \fwrite($file, $txt);
                $txt = "];\n";
                \fwrite($file, $txt);
                // close opened file
                \fclose($file);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale(string $language)
    {
        $this->language = $language;
        $this->translated_file = $language . '.php';
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTranslateDir(string $directory)
    {
        $directory = $this->changeSlashes($directory);
        if (\file_exists($directory) && \is_dir($directory)) {
            $this->translate_dir = $directory;
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslateFromFile(string $filename, bool $fresh = false): array
    {
        if (isset($this->resolved_files[$this->language]) && \in_array($filename, $this->resolved_files[$this->language]) && !$fresh) {
            return $this->resolved_files[$this->language][$filename];
        }
        return $this->resolveFile($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * {@inheritdoc}
     */
    public function itIsRTL()
    {
        $this->is_rtl = true;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isRTL(): bool
    {
        return $this->is_rtl || ISOLanguageCodes::isRtlLanguage($this->language);
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $key, $fileOrValue = null, array $value = [])
    {
        $dir = $this->translate_dir;
        $filename = $this->translated_file;
        if (\is_string($fileOrValue)) {
            $filename = \explode(':', $fileOrValue);
            if (2 <= \count($filename) && 'file' === $filename[0]) {
                \array_shift($filename);
                $dir = '';
                $filename = \implode(':', $filename) . '.php';
            } else {
                $filename = $fileOrValue . '.php';
            }
        }

        $arr = $this->getTranslateFromFile(\rtrim($dir . DIRECTORY_SEPARATOR . $filename, DIRECTORY_SEPARATOR));
        $translate = ArrayUtil::get($arr, $key);
        if (\is_null($translate)) return '';

        $mapper = $value;
        if (\is_array($fileOrValue)) {
            $mapper = $fileOrValue;
        }
        if (\count($mapper)) {
            foreach ($mapper as $k => $v) {
                if (\is_string($v)) {
                    $translate = \str_replace('{' . $k . '}', $v, $translate);
                }
            }
        }

        return $translate;
    }

    /**
     * @param string $filename
     * @return array
     */
    protected function resolveFile(string $filename): array
    {
        if (\file_exists($filename)) {
            // sorry I had to concat it with a string to avoid editor's warning :(
            $arr = include $filename . '';
            if (!\is_array($arr)) {
                $arr = [];
            }
        } else {
            $arr = [];
        }

        if (!isset($this->resolved_files[$this->language][$filename]) || !\is_array($this->resolved_files[$this->language][$filename])) {
            $this->resolved_files[$this->language][$filename] = [];
        }
        $this->resolved_files[$this->language][$filename] = \array_merge($this->resolved_files[$this->language], $arr);

        return $arr;
    }

    /**
     * @param $str
     * @return mixed|string
     */
    protected function changeSlashes($str)
    {
        $str = \str_replace('/', DIRECTORY_SEPARATOR, $str);
        $str = \str_replace('\\', DIRECTORY_SEPARATOR, $str);
        $str = \rtrim($str, DIRECTORY_SEPARATOR);
        return $str;
    }
}