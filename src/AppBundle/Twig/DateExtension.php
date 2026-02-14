<?php

namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_date', [$this, 'formatDate']),
        ];
    }

    public function formatDate(
        \DateTimeInterface $date,
        string $locale = 'fr',
        string $dateFormat = 'medium',
        ?string $pattern = null
    ): string {
        if ($pattern !== null) {
            $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, null, null, $pattern);
        } else {
            $intlFormat = match ($dateFormat) {
                'full'   => \IntlDateFormatter::FULL,
                'long'   => \IntlDateFormatter::LONG,
                'short'  => \IntlDateFormatter::SHORT,
                default  => \IntlDateFormatter::MEDIUM,
            };
            $formatter = new \IntlDateFormatter($locale, $intlFormat, \IntlDateFormatter::NONE);
        }

        return $formatter->format($date) ?: '';
    }
}
