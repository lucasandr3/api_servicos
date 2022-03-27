<?php

namespace App\Helpers;

use DateTime;

class Helpers
{
    public static function formatMoney(float $value, int $precision = 2): string
    {
        return "R$ " . number_format($value, $precision, ',','.');
    }

    public static function formatDateSimple(string $date): string
    {
        return $date = date('d/m/Y', strtotime($date));
    }

    public static function formatDateHour(string $date): string
    {
        $d = date('d/m/Y', strtotime($date));
        $h = date('H:i', strtotime($date));

        return $d ." às ".$h;
    }

    public static function Hour(string $date): string
    {
        return date('H:i', strtotime($date));
    }

    public static function formatInterest(float $value, int $precision = 1): string
    {
        return number_format($value, $precision, '.','.') . "%";
    }

    public static function formatDocument(string $value): string
    {
        $cnpj_cpf = preg_replace("/\D/", '', $value);
        $result = $value;

        if (strlen($cnpj_cpf) === 11) {
            $result = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } elseif (strlen($cnpj_cpf) === 14) {
            $result = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
        }

        return $result;
    }

    public static function formatPhone(string $telefone): string
    {
        $size = strlen($telefone);
        $string = preg_replace("[^0-9]", "", $telefone);

        if ($size === 10) {
            $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) . '-' . substr($string, 6);
        } else if ($size === 11) {
            $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 5) . '-' . substr($string, 7);
        }
        return $string;
    }

    public static function formatZipcode(string $cep): string
    {
        $string = preg_replace("[^0-9]", "", $cep);
        return substr($string, 0, 5) . '-' . substr($string, 5, 3);
    }

    public static function groupByMonth($data)
    {
        $months = [
            '1' => 'Janeiro',
            '2' => 'Fevereiro',
            '3' => 'Março',
            '4' => 'Abril',
            '5' => 'Maio',
            '6' => 'Junho',
            '7' => 'Julho',
            '8' => 'Agosto',
            '9' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];

        usort($data, function($a, $b) {
            return $a->month >= $b->month;
        });

        $dataMonths = [];

        foreach ($data as $d) {
            $dataMonths[$months[$d->month]][] = $d;
        }

        return $dataMonths;
    }

    public static function groupByCardsColumn($data)
    {
        usort($data, function ($a, $b) {
            return $a->institution >= $b->institution;
        });

        $groupData = [];

        foreach ($data as $k => $d) {
            $groupData[self::cleanString($d->institution)][] = $d;
        }

        return $groupData;
    }

    public static function calcValues($values)
    {
        $total = 0;

        foreach ($values as $index => $value) {
            foreach ($values[$index] as $v) {
                $total += $v->total;
            }
        }

        return $total;
    }

    public static function cleanString($string = NULL)
    {
        $procurar = array('À', 'Á', 'Ã', 'Â', 'É', 'Ê', 'Í', 'Ó', 'Õ', 'Ô', 'Ú', 'Ü', 'Ç', 'à', 'á', 'ã', 'â', 'é', 'ê', 'í', 'ó', 'õ', 'ô', 'ú', 'ü', 'ç');
        $substituir = array('a', 'a', 'a', 'a', 'e', 'r', 'i', 'o', 'o', 'o', 'u', 'u', 'c', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'c');
        return str_replace($procurar, $substituir, strtolower(self::slugify($string)));
    }

    public static function slugify($text)
    {
        $replace = [
            '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
            '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae',
            '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
            'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
            'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
            'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
            'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
            'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
            'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
            'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
            'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
            'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
            'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
            '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
            'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
            'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
            'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
            'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
            'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
            'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
            'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
            'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
            'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
            'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
            '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
            'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
            'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
            'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
            'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
            'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
            'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
            'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
            'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
            'ю' => 'yu', 'я' => 'ya'
        ];

        // make a human readable string
        $text = strtr($text, $replace);

        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d.]+~u', '_', $text);

        // trim
        $text = trim($text, '_');

        // remove unwanted characters
        $text = preg_replace('~[^-\w.]+~', '', $text);

        $text = strtolower($text);

        return $text;
    }

    public static function statusHotmart($status)
    {
        $response = '';

        switch ($status) {
            case 'ACTIVE':
                $response = 'Ativo';
                break;
            case 'INACTIVE':
                $response = 'Inativo';
                break;
            case 'DELAYED':
                $response = 'Atrasado';
                break;
            case 'CANCELLED_BY_CUSTOMER':
                $response = 'Cancelado pelo Cliente';
                break;
            case 'CANCELLED_BY_SELLER':
                $response = 'Cancelado pelo Comprador';
                break;
            case 'CANCELLED_BY_ADMIN':
                $response = 'Cancelado pelo Administrador';
                break;
            case 'STARTED':
                $response = 'Iniciada';
                break;
            case 'OVERDUE':
                $response = 'Atrasada';
                break;
        }

        return $response;
    }

    public static function tipoMetodoPagamento($metodo)
    {
        $response = '';

        switch ($metodo) {
            case 'BILLET':
                $response = 'Boleto';
                break;
            case 'PAYPAL':
                $response = 'Paypal';
                break;
            case 'BANCO_BRASIL_ONLINE_TRANSFER':
                $response = 'Transferência Banco do Brasil';
                break;
            case 'BRADESCO_ONLINE_TRANSFER':
                $response = 'Transferência Banco Bradesco';
                break;
            case 'ITAU_ONLINE_TRANSFER':
                $response = 'Transferência Banco Itaú';
                break;
            case 'VISA_CREDIT_CARD':
                $response = 'Cartão de Crédito Visa';
                break;
            case 'MASTERCARD_CREDIT_CARD':
                $response = 'Cartão de Crédito Mastercard';
                break;
            case 'AMERICAN_EXPRESS_CREDIT_CARD':
                $response = 'Cartão de Crédito American Express';
                break;
            case 'AURA_CREDIT_CARD':
                $response = 'Cartão de Crédito Aura';
                break;
            case 'DINERS_CREDIT_CARD':
                $response = 'Cartão de Crédito Diners';
                break;
            case 'HIPERCARD_CREDIT_CARD':
                $response = 'Cartão de Crédito Hipercard';
                break;
            case 'ELO_CREDIT_CARD':
                $response = 'Cartão de Crédito Elo';
                break;
            case 'HOTMART':
                $response = 'Hotmart';
                break;
            case 'BANK_DEBT':
                $response = 'Débito Bancário';
                break;
            case 'DISCOVER_CREDIT_CARD':
                $response = 'Cartão de Crédito Discover';
                break;
            case 'SEPA_DIRECT_DEBT':
            case 'MULTIBANK':
                $response = 'SEPA Débito / MULTIBANK';
                break;
        }

        return $response;
    }

    public static function tipoPagamento($tipo)
    {
        $response = '';

        switch ($tipo) {
            case 'BILLET':
                $response = 'Boleto';
                break;
            case 'CREDIT_CARD':
                $response = 'Cartão de Crédito';
                break;
            case 'PAYPAL':
                $response = 'Paypal';
                break;
            case 'BANK_DEBT':
                $response = 'Dédito Bancário';
                break;
            case 'HOTMART_BALANCE':
                $response = 'Saldo Hotmart';
                break;
            case 'CASH_PAYMENT':
                $response = 'Dinheiro';
                break;
            case 'SAMSUNG_PAY':
                $response = 'Samsung pay';
                break;
            case 'GOOGLE_PAY':
                $response = 'Google pay';
                break;
        }

        return $response;
    }

    public static function statusCompra($status)
    {
        $response = '';

        switch ($status) {
            case 'STARTED':
                $response = 'Iniciada';
                break;
            case 'PROCESSING_TRANSACTION':
                $response = 'Processando Transação';
                break;
            case 'COMPLETE':
                $response = 'Finalizado';
                break;
            case 'PRINTED_BILLET':
                $response = 'Imprimiu o Boleto';
                break;
            case 'WAITING_PAYMENT':
                $response = 'Aguardando Pagamento';
                break;
            case 'APPROVED':
                $response = 'Aprovada';
                break;
            case 'UNDER_ANALISYS':
                $response = 'Sob Análise';
                break;
            case 'CANCELLED':
                $response = 'Cancelada';
                break;
            case 'PROTESTED':
                $response = 'Protesto';
                break;
            case 'REFUNDED':
                $response = 'Devolveu';
                break;
            case 'CHARGEBACK':
                $response = 'Estorno';
                break;
            case 'BLOCKED':
                $response = 'Bloqueado';
                break;
            case 'OVERDUE':
                $response = 'Atrasada';
                break;
            case 'PRE_ORDER':
                $response = 'Pedido Antecipado';
                break;
            case 'NO_FUNDS':
                $response = 'Sem Fundos';
                break;
            case 'EXPIRED':
                $response = 'Expirada';
                break;
        }

        return $response;
    }

    public static function formataHoraMilesegundos($hora)
    {
        $micro = sprintf("%06d",($hora - floor($hora)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $hora) );

        $dia = $d->format("d/m/Y");
        $hora = " às " . $d->format("H:i");
        return $dia . $hora;
    }

    public static function status($status)
    {
        $response = '';

        switch ($status) {
            case 'ACTIVE':
                $response = 'Ativo';
                break;
            case 'INACTIVE':
                $response = 'Inativo';
                break;
        }

        return $response;
    }
}
