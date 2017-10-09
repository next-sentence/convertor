<?php

namespace AppBundle\Term;


class TermBuilder
{
    const EQ = '=';
    const LT = '<';
    const GT = '>';

    const TYPE_AND = ' AND ';
    const TYPE_OR = ' OR ';

    /**
     * @param $arg
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function buildTerms($arg, $type = self::TYPE_AND) :string
    {
        $terms = [];

        foreach ($arg as $key => $value)
        {
            switch (true) {
                case !is_array($value):
                    $terms[$type][] = $this->eq($key, self::EQ,$value);
                    break;
                case is_array($value) && isset($value['gt']):
                    $terms[$type][] = $this->eq($key, self::GT, $value['gt']);
                    break;
                case is_array($value) && isset($value['lt']):
                    $terms[$type][] = $this->eq($key,self::LT, $value['lt']);
                    break;
                case is_array($value) && $key === 'or':
                    $terms[self::TYPE_OR][] = $this->buildTerms($value, self::TYPE_OR);
                    break;
                case is_array($value):
                    $terms[self::TYPE_AND][] = $this->buildTerms($value, self::TYPE_AND);
                    break;
                default:
                    throw new \Exception('not supported');
            }
        }

        if (isset($terms[self::TYPE_AND])) {
            $terms[self::TYPE_AND] = '(' . implode(')' . $type . '(', $terms[self::TYPE_AND]) . ')';
        }

        if (isset($terms[self::TYPE_OR])) {
            $terms[self::TYPE_OR] = '(' . implode(')' . $type . '(', $terms[self::TYPE_OR]) . ')';
        }

        return implode($type, $terms);
    }

    /**
     * @param $field
     * @param $operator
     * @param $value
     * @return string
     */
    protected function eq($field, $operator, $value) :string
    {
        return $field . ' ' . $operator . ' ' . $value;
    }
}
