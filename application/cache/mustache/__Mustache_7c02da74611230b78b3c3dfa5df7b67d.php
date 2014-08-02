<?php

class __Mustache_7c02da74611230b78b3c3dfa5df7b67d extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'cssfile' section
        $value = $context->find('cssfile');
        $buffer .= $this->sectionAdcfbe85352f194459f64b6f3f4bd641($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . 'Hello, ';
        $value = $this->resolveValue($context->find('title'), $context, $indent);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '
';
        // 'css' section
        $value = $context->find('css');
        $buffer .= $this->section64e7569c00cda1a0f7a3152720a7288c($context, $indent, $value);

        return $buffer;
    }

    private function sectionAdcfbe85352f194459f64b6f3f4bd641(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = 'qq/test.css';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                $buffer .= $indent . 'qq/test.css';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section64e7569c00cda1a0f7a3152720a7288c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{{ . }}}
';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                $buffer .= $indent . '    ';
                $value = $this->resolveValue($context->last(), $context, $indent);
                $buffer .= $value;
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
