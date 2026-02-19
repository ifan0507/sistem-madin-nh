<?php

if (!function_exists('getKelasArab')) {
    /**
     *
     * @param int|string $kelasId
     * @return string
     */
    function getKelasArab($kelasId)
    {
        $arabMap = [
            1 => 'صفر',
            2 => 'الأول',
            3 => 'الثاني',
            4 => 'الثالث',
            5 => 'الرابع',
            6 => 'الخامس',
            7 => 'السادس',
        ];

        return $arabMap[$kelasId] ?? $kelasId;
    }
}
