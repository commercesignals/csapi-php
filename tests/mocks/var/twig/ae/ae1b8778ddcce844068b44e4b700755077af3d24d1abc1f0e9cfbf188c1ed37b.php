<?php

/* Hello {{ request.query.get('name') }}!
 */
class __TwigTemplate_3c7a3e07915b2b24288b4afbab7c450a09db5626114b1aac0c49518046a09232 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Hello ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["request"]) ? $context["request"] : null), "query", array()), "get", array(0 => "name"), "method"), "html", null, true);
        echo "!
";
    }

    public function getTemplateName()
    {
        return "Hello {{ request.query.get('name') }}!
";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("Hello {{ request.query.get('name') }}!
", "Hello {{ request.query.get('name') }}!
", "");
    }
}
