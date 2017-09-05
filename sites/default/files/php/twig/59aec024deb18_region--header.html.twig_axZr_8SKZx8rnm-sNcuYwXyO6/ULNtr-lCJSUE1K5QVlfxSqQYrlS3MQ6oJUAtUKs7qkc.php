<?php

/* themes/custom/bethelks/templates/bethelks_layout/region--header.html.twig */
class __TwigTemplate_68edd7ed81392b95bd9ba88ec37df63f5d31e408a0a21d188bfe5c51d3923dab extends Twig_Template
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
        $tags = array("if" => 22);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
                array(),
                array()
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

        // line 15
        echo "<div class=\"container-fluid header-thresherConnectBar d-flex justify-content-center justify-content-sm-end\">
  <a href=\"#\">Thresher Connect</a>
</div>
<nav class=\"navbar navbar-expand-lg navbar-light\">
  ";
        // line 19
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["content"]) ? $context["content"] : null), "html", null, true));
        echo "
</nav>

";
        // line 22
        if ((isset($context["is_front"]) ? $context["is_front"] : null)) {
            // line 23
            echo "  <div class=\"container-fluid header-eyecatcher\">
    <div class=\"header-eyecatcher-video-overlay\">
      <p>Click anywhere on the video to pause/play.</p>
    </div>

    <div class=\"header-eyecatcher-video\">
      <video autoplay loop muted>
        <source src=\"";
            // line 30
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, ((isset($context["directory"]) ? $context["directory"] : null) . "/VideoHeader.mp4"), "html", null, true));
            echo "\" type=\"video/mp4\">
      </video>
    </div>
  </div>
";
        } else {
            // line 35
            echo "  <div class=\"container-fluid header-eyecatcher header-eyecatcher-image\">
    <div class=\"container\">
      <div class=\"header-eyecatcher-overlay d-flex justify-content-center justify-content-md-start align-items-center\">
        <div class=\"row\">
          <div class=\"col-12\"><h2>Connect to Purpose</h2></div>
          <div class=\"col-12\"><a href=\"#\">Explore</a></div>
        </div>
      </div>
    </div>
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "themes/custom/bethelks/templates/bethelks_layout/region--header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 35,  66 => 30,  57 => 23,  55 => 22,  49 => 19,  43 => 15,);
    }

    public function getSource()
    {
        return "{#
/**
 * @file
 * Theme override to display a region.
 *
 * Available variables:
 * - content: The content for this region, typically blocks.
 * - attributes: HTML attributes for the region div.
 * - region: The name of the region variable as defined in the theme's
 *   .info.yml file.
 *
 * @see template_preprocess_region()
 */
#}
<div class=\"container-fluid header-thresherConnectBar d-flex justify-content-center justify-content-sm-end\">
  <a href=\"#\">Thresher Connect</a>
</div>
<nav class=\"navbar navbar-expand-lg navbar-light\">
  {{ content }}
</nav>

{% if is_front %}
  <div class=\"container-fluid header-eyecatcher\">
    <div class=\"header-eyecatcher-video-overlay\">
      <p>Click anywhere on the video to pause/play.</p>
    </div>

    <div class=\"header-eyecatcher-video\">
      <video autoplay loop muted>
        <source src=\"{{ directory ~ '/VideoHeader.mp4' }}\" type=\"video/mp4\">
      </video>
    </div>
  </div>
{% else %}
  <div class=\"container-fluid header-eyecatcher header-eyecatcher-image\">
    <div class=\"container\">
      <div class=\"header-eyecatcher-overlay d-flex justify-content-center justify-content-md-start align-items-center\">
        <div class=\"row\">
          <div class=\"col-12\"><h2>Connect to Purpose</h2></div>
          <div class=\"col-12\"><a href=\"#\">Explore</a></div>
        </div>
      </div>
    </div>
  </div>
{% endif %}
";
    }
}
