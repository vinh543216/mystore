<?php

/* modules/shopnew/templates//cart/cart.html.twig */
class __TwigTemplate_ebe1dab1a478bd31d2afe1fc9029298dc7db8b6bf3a02335e9fc52a80707d4ea extends Twig_Template
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
        $tags = array("if" => 14, "trans" => 17, "for" => 23);
        $filters = array("trans" => 44);
        $functions = array("url" => 42);

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if', 'trans', 'for'),
                array('trans'),
                array('url')
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
        echo "<h3>List cart</h3>
<div>
  <table class=\"table table-hover\">
    <thead>
    <tr>
      <th>Name</th>
      <th>Quality</th>
      <th>Price</th>
      <th></th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    ";
        // line 14
        if ($this->getAttribute(($context["data"] ?? null), "message", array())) {
            // line 15
            echo "      <div class=\"alert alert-danger alert-dismissable\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
        ";
            // line 17
            echo t("@data.message", array("@data.message" => $this->getAttribute(            // line 18
($context["data"] ?? null), "message", array()), ));
            // line 20
            echo "      </div>
    ";
        }
        // line 22
        echo "    ";
        if ($this->getAttribute(($context["data"] ?? null), "product", array(), "array")) {
            // line 23
            echo "      ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["data"] ?? null), "product", array(), "array"));
            foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
                // line 24
                echo "        <tr>
          <td>";
                // line 25
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["value"], "title", array(), "array"), "html", null, true));
                echo "</td>
          <td><input class=\"qty\" value=\"";
                // line 26
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["value"], "quality", array(), "array"), "html", null, true));
                echo "\"></td>
          <td>";
                // line 27
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["value"], "price", array(), "array"), "html", null, true));
                echo "</td>
          <td><a href=\"#\" id=\"";
                // line 28
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["value"], "id", array()), "html", null, true));
                echo "\" class=\"updateCart\"> <span class=\"glyphicon glyphicon-refresh\"></span>
              <Refresh></Refresh>
            </a></td>
          <td><a href=\"#\" id=\"";
                // line 31
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["value"], "id", array()), "html", null, true));
                echo "\" class=\"deleteCart\"> <span class=\"glyphicon glyphicon-remove\"></span>
              Remove </a></td>
        </tr>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 35
            echo "      <tr>
        <td></td>
        <td>Total:</td>
        <td>";
            // line 38
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["data"] ?? null), "total", array(), "array"), "html", null, true));
            echo "</td>
        <td></td>
        <td></td>
      </tr>
      <div><a href=\"";
            // line 42
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getUrl("shopnew.order")));
            echo "\" class=\"btn btn-success\">Check Out</a></div>
    ";
        } else {
            // line 44
            echo "      <div class=\"alert alert-danger\">";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("No product exits in your cart")));
            echo "</div>
    ";
        }
        // line 46
        echo "    </tbody>
  </table>
</div>

";
    }

    public function getTemplateName()
    {
        return "modules/shopnew/templates//cart/cart.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 46,  127 => 44,  122 => 42,  115 => 38,  110 => 35,  100 => 31,  94 => 28,  90 => 27,  86 => 26,  82 => 25,  79 => 24,  74 => 23,  71 => 22,  67 => 20,  65 => 18,  64 => 17,  60 => 15,  58 => 14,  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/shopnew/templates//cart/cart.html.twig", "E:\\xampp\\htdocs\\mystore\\web\\modules\\shopnew\\templates\\cart\\cart.html.twig");
    }
}
