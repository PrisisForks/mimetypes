<?php
declare(strict_types=1);
namespace Narrowspark\MimeType;

use Narrowspark\MimeType\Exception\AccessDeniedException;
use Narrowspark\MimeType\Exception\FileNotFoundException;

class MimeTypeFileExtensionGuesser extends MimeTypeExtensionGuesser
{
    /**
     * {@inheritdoc}
     */
    public static function isSupported(): bool
    {
        return \function_exists('pathinfo');
    }

    /**
     * Guesses the mime type using the file extension.
     *
     * @param string $guess The path to the file
     *
     * @throws \Narrowspark\MimeType\Exception\FileNotFoundException If the file does not exist
     * @throws \Narrowspark\MimeType\Exception\AccessDeniedException If the file could not be read
     *
     * @return null|string
     */
    public static function guess(string $guess): ?string
    {
        if (! \is_file($guess)) {
            throw new FileNotFoundException($guess);
        }

        if (! \is_readable($guess)) {
            throw new AccessDeniedException($guess);
        }

        return parent::guess(\pathinfo($guess, \PATHINFO_EXTENSION));
    }
}
