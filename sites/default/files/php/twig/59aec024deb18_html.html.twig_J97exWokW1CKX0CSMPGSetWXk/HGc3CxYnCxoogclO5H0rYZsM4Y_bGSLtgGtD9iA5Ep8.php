<?php

/* themes/custom/bethelks/templates/bethelks_layout/html.html.twig */
class __TwigTemplate_09fbcb088f3165503c4524002f1be7f9f194fc7249a75b0583373d18e0080cf3 extends Twig_Template
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
        $tags = array("if" => 47);
        $filters = array("raw" => 29, "safe_join" => 31);
        $functions = array("attach_library" => 35);

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
                array('raw', 'safe_join'),
                array('attach_library')
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setTemplateFile($this->getTemplateName());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 26
        echo "<!DOCTYPE html>
<html";
        // line 27
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["html_attributes"]) ? $context["html_attributes"] : null), "html", null, true));
        echo ">
  <head>
    <head-placeholder token=\"";
        // line 29
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["placeholder_token"]) ? $context["placeholder_token"] : null)));
        echo "\">
    <link rel=\"icon\" type=\"image/png\" href=\"themes/custom/bethelks/favicon.png\">
    <title>";
        // line 31
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar($this->env->getExtension('drupal_core')->safeJoin($this->env, (isset($context["head_title"]) ? $context["head_title"] : null), " | ")));
        echo "</title>
    <css-placeholder token=\"";
        // line 32
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["placeholder_token"]) ? $context["placeholder_token"] : null)));
        echo "\">
    <js-placeholder token=\"";
        // line 33
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["placeholder_token"]) ? $context["placeholder_token"] : null)));
        echo "\">

    ";
        // line 35
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bethelks/bootstrap-css"), "html", null, true));
        echo "
    ";
        // line 36
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bethelks/font-awesome-css"), "html", null, true));
        echo "
    ";
        // line 37
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bethelks/global-css"), "html", null, true));
        echo "

    ";
        // line 39
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bethelks/bootstrap-js"), "html", null, true));
        echo "
    ";
        // line 40
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bethelks/parallax-js"), "html", null, true));
        echo "
    ";
        // line 41
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bethelks/isotope-js"), "html", null, true));
        echo "
    ";
        // line 42
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("bethelks/global-js"), "html", null, true));
        echo "
  </head>
  <body";
        // line 44
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["attributes"]) ? $context["attributes"] : null), "html", null, true));
        echo ">
    ";
        // line 45
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["page_top"]) ? $context["page_top"] : null), "html", null, true));
        echo "

    ";
        // line 47
        if (twig_test_empty($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "header", array()))) {
            // line 48
            echo "      <div class=\"alert alert-danger container\" role=\"alert\">
        <p><strong>Error!</strong> No data found within the page header. Please contact the site administrator.</p>
      </div>
    ";
        } else {
            // line 52
            echo "      ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "header", array()), "html", null, true));
            echo "
    ";
        }
        // line 54
        echo "
    ";
        // line 55
        if (twig_test_empty($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "postHeader", array()))) {
            // line 56
            echo "      <div class=\"alert alert-danger container\" role=\"alert\">
        <p><strong>Error!</strong> No data found within the page post-header. Please contact the site administrator.</p>
      </div>
    ";
        } else {
            // line 60
            echo "      ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "postHeader", array()), "html", null, true));
            echo "
    ";
        }
        // line 62
        echo "
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-12 col-lg-9\">
          ";
        // line 66
        if (twig_test_empty($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array()))) {
            // line 67
            echo "            <div class=\"alert alert-danger\" role=\"alert\">
              <p><strong>Error!</strong> No data found within the page content. Please contact the site administrator.</p>
            </div>
          ";
        } else {
            // line 71
            echo "            ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array()), "html", null, true));
            echo "
          ";
        }
        // line 73
        echo "        </div>
        <div class=\"col-12 col-lg-3\">
          ";
        // line 75
        if (twig_test_empty($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "rightSidebar", array()))) {
            // line 76
            echo "            <div class=\"alert alert-danger\" role=\"alert\">
              <p><strong>Error!</strong> No data found within the page right-sidebar. Please contact the site administrator.</p>
            </div>
          ";
        } else {
            // line 80
            echo "            ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "rightSidebar", array()), "html", null, true));
            echo "
          ";
        }
        // line 82
        echo "        </div>
      </div>
    </div>

    <div class=\"container-fluid preFooterFull\">
      <div class=\"container\">
        ";
        // line 88
        if (twig_test_empty($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "preFooter", array()))) {
            // line 89
            echo "          <div class=\"alert alert-danger\" role=\"alert\">
            <p><strong>Error!</strong> No data found within the page pre-footer. Please contact the site administrator.</p>
          </div>
        ";
        } else {
            // line 93
            echo "          ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "preFooter", array()), "html", null, true));
            echo "
        ";
        }
        // line 95
        echo "      </div>
    </div>

    <div class=\"container-fluid footerFull\">
      <div class=\"container\">
        ";
        // line 100
        if (twig_test_empty($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "footer", array()))) {
            // line 101
            echo "          <div class=\"alert alert-danger container\" role=\"alert\">
            <p><strong>Error!</strong> No data found within the page footer. Please contact the site administrator.</p>
          </div>
        ";
        } else {
            // line 105
            echo "          ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "footer", array()), "html", null, true));
            echo "
        ";
        }
        // line 107
        echo "      </div>
    </div>

    ";
        // line 110
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["page_bottom"]) ? $context["page_bottom"] : null), "html", null, true));
        echo "

    <js-bottom-placeholder token=\"";
        // line 112
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["placeholder_token"]) ? $context["placeholder_token"] : null)));
        echo "\">
  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/bethelks/templates/bethelks_layout/html.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 112,  225 => 110,  220 => 107,  214 => 105,  208 => 101,  206 => 100,  199 => 95,  193 => 93,  187 => 89,  185 => 88,  177 => 82,  171 => 80,  165 => 76,  163 => 75,  159 => 73,  153 => 71,  147 => 67,  145 => 66,  139 => 62,  133 => 60,  127 => 56,  125 => 55,  122 => 54,  116 => 52,  110 => 48,  108 => 47,  103 => 45,  99 => 44,  94 => 42,  90 => 41,  86 => 40,  82 => 39,  77 => 37,  73 => 36,  69 => 35,  64 => 33,  60 => 32,  56 => 31,  51 => 29,  46 => 27,  43 => 26,);
    }

    public function getSource()
    {
        return "{#
/**
 * @file
 * Theme override for the basic structure of a single Drupal page.
 *
 * Variables:
 * - logged_in: A flag indicating if user is logged in.
 * - root_path: The root path of the current page (e.g., node, admin, user).
 * - node_type: The content type for the current node, if the page is a node.
 * - head_title: List of text elements that make up the head_title variable.
 *   May contain one or more of the following:
 *   - title: The title of the page.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site.
 * - page_top: Initial rendered markup. This should be printed before 'page'.
 * - page: The rendered page markup.
 * - page_bottom: Closing rendered markup. This variable should be printed after
 *   'page'.
 * - db_offline: A flag indicating if the database is offline.
 * - placeholder_token: The token for generating head, css, js and js-bottom
 *   placeholders.
 *
 * @see template_preprocess_html()
 */
#}
<!DOCTYPE html>
<html{{ html_attributes }}>
  <head>
    <head-placeholder token=\"{{ placeholder_token|raw }}\">
    <link rel=\"icon\" type=\"image/png\" href=\"themes/custom/bethelks/favicon.png\">
    <title>{{ head_title|safe_join(' | ') }}</title>
    <css-placeholder token=\"{{ placeholder_token|raw }}\">
    <js-placeholder token=\"{{ placeholder_token|raw }}\">

    {{ attach_library('bethelks/bootstrap-css') }}
    {{ attach_library('bethelks/font-awesome-css') }}
    {{ attach_library('bethelks/global-css') }}

    {{ attach_library('bethelks/bootstrap-js') }}
    {{ attach_library('bethelks/parallax-js') }}
    {{ attach_library('bethelks/isotope-js') }}
    {{ attach_library('bethelks/global-js') }}
  </head>
  <body{{ attributes }}>
    {{ page_top }}

    {% if page.header is empty %}
      <div class=\"alert alert-danger container\" role=\"alert\">
        <p><strong>Error!</strong> No data found within the page header. Please contact the site administrator.</p>
      </div>
    {% else %}
      {{ page.header }}
    {% endif %}

    {% if page.postHeader is empty %}
      <div class=\"alert alert-danger container\" role=\"alert\">
        <p><strong>Error!</strong> No data found within the page post-header. Please contact the site administrator.</p>
      </div>
    {% else %}
      {{ page.postHeader }}
    {% endif %}

    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-12 col-lg-9\">
          {% if page.content is empty %}
            <div class=\"alert alert-danger\" role=\"alert\">
              <p><strong>Error!</strong> No data found within the page content. Please contact the site administrator.</p>
            </div>
          {% else %}
            {{ page.content }}
          {% endif %}
        </div>
        <div class=\"col-12 col-lg-3\">
          {% if page.rightSidebar is empty %}
            <div class=\"alert alert-danger\" role=\"alert\">
              <p><strong>Error!</strong> No data found within the page right-sidebar. Please contact the site administrator.</p>
            </div>
          {% else %}
            {{ page.rightSidebar }}
          {% endif %}
        </div>
      </div>
    </div>

    <div class=\"container-fluid preFooterFull\">
      <div class=\"container\">
        {% if page.preFooter is empty %}
          <div class=\"alert alert-danger\" role=\"alert\">
            <p><strong>Error!</strong> No data found within the page pre-footer. Please contact the site administrator.</p>
          </div>
        {% else %}
          {{ page.preFooter }}
        {% endif %}
      </div>
    </div>

    <div class=\"container-fluid footerFull\">
      <div class=\"container\">
        {% if page.footer is empty %}
          <div class=\"alert alert-danger container\" role=\"alert\">
            <p><strong>Error!</strong> No data found within the page footer. Please contact the site administrator.</p>
          </div>
        {% else %}
          {{ page.footer }}
        {% endif %}
      </div>
    </div>

    {{page_bottom}}

    <js-bottom-placeholder token=\"{{ placeholder_token|raw }}\">
  </body>
</html>
";
    }
}
