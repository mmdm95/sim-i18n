<?php

namespace Sim\I18n\Interfaces;

interface ITranslate
{
    /**
     * Creates a php file with name of $language
     * in specified directory
     *
     * Note: If directory is not specified, it tries
     * to create file in directory that specified with
     * <em>setTranslateDir<em> method.
     *
     * @param string $language
     * @param string $directory
     * @return static
     */
    public function createLanguageFile(string $language, string $directory);

    /**
     * @param string $language
     * @return static
     */
    public function setLocale(string $language);

    /**
     * Set translate folder that contains all other
     * translate files
     *
     * @param string $directory
     * @return static
     */
    public function setTranslateDir(string $directory);

    /**
     * Get all translations from $filename
     *
     * @param string $filename
     * @param bool $fresh
     * @return array
     */
    public function getTranslateFromFile(string $filename, bool $fresh = false): array;

    /**
     * @return string
     */
    public function getLanguage(): string;

    /**
     * Check the locale language as rtl
     *
     * @return static
     */
    public function itIsRTL();

    /**
     * @return bool
     */
    public function isRTL(): bool;

    /**
     * Get translated word
     *
     * @param string $key
     * @param array|string|null $fileOrValue - You can pass translate filename
     * right here or entire translate directory + filename by entering [file:] prefix
     * or you can pass translate values array
     * @param array|null $value
     * @return mixed
     */
    public function translate(string $key, $fileOrValue = null, array $value = []);
}