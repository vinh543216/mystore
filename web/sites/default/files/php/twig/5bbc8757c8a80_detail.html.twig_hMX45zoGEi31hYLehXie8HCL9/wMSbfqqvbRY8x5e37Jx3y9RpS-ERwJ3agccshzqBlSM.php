<?php

/* modules/shopnew/templates//product/detail.html.twig */
class __TwigTemplate_bfd6d0e537db7805654185987ea480d31867888278a927febd0dd3485cf8c27c extends Twig_Template
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
        $tags = array("if" => 2, "for" => 10);
        $filters = array("raw" => 31);
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if', 'for'),
                array('raw'),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 1
        echo "<div class=\"detail\">
  ";
        // line 2
        if (($context["data"] ?? null)) {
            // line 3
            echo "    <div class=\"col-sm-12 product\">
      <h3>";
            // line 4
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["data"] ?? null), "title", array()), "html", null, true));
            echo " </h3>
      <div>
        <div class=\"col-sm-4 image\">
          <div><img src=\"";
            // line 7
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["data"] ?? null), "imagePath", array()), "html", null, true));
            echo "\" width=\"100%\"></div>
          <div>
            ";
            // line 9
            if ($this->getAttribute(($context["data"] ?? null), "images", array())) {
                // line 10
                echo "              ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["data"] ?? null), "images", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
                    // line 11
                    echo "                <span><img src=\"";
                    echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["value"], "imagePath", array()), "html", null, true));
                    echo "\" width=\"50px\"></span>
              ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 13
                echo "            ";
            }
            // line 14
            echo "          </div>
        </div>
        <div class=\"col-sm-8 description\">
          <div>
            ";
            // line 18
            if ($this->getAttribute(($context["data"] ?? null), "description", array())) {
                // line 19
                echo "              ";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["data"] ?? null), "description", array()), "html", null, true));
                echo "
            ";
            }
            // line 21
            echo "          </div>
          <div class=\"add-to-card\">
            ";
            // line 23
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["data"] ?? null), "form", array()), "html", null, true));
            echo "
          </div>
        </div>
      </div>
    </div>
    <div class=\"col-sm-12 content\">
      <div>
        ";
            // line 30
            if ($this->getAttribute(($context["data"] ?? null), "content", array())) {
                // line 31
                echo "          ";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["data"] ?? null), "content", array())));
                echo "
        ";
            }
            // line 33
            echo "      </div>
    </div>
  ";
        } else {
            // line 36
            echo "    <div class=\"alert alert-danger alert-dismissible\">
      <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
      <strong>Info!</strong>Sản phẩm không tìm thấy
    </div>
  ";
        }
        // line 41
        echo "</div>

";
    }

    public function getTemplateName()
    {
        return "modules/shopnew/templates//product/detail.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 41,  122 => 36,  117 => 33,  111 => 31,  109 => 30,  99 => 23,  95 => 21,  89 => 19,  87 => 18,  81 => 14,  78 => 13,  69 => 11,  64 => 10,  62 => 9,  57 => 7,  51 => 4,  48 => 3,  46 => 2,  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/shopnew/templates//product/detail.html.twig", "E:\\xampp\\htdocs\\mystore\\web\\modules\\shopnew\\templates\\product\\detail.html.twig");
    }
}
