<?php

/* modules/bethelks_facilities/templates/facility-list-admin-template.html.twig */
class __TwigTemplate_18d81e76e3d79cecff97ae0280c43a79dbb4ba56b4c243ba5507a6f9fa31800c extends Twig_Template
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
        $tags = array("if" => 15, "for" => 20);
        $filters = array("title" => 23, "replace" => 23);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if', 'for'),
                array('title', 'replace'),
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

        // line 1
        echo "<a href=\"";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "link", array()), "html", null, true));
        echo "/0/ae\"><button style=\"margin-bottom:10px;\" class=\"button button-action button--primary\">Add facility</button></a>
<h1>";
        // line 2
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "title", array()), "html", null, true));
        echo "</h1>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Mapid</th>
      <th>title</th>
      <th>description</th>
      <th>image</th>
      <th>action</th>
    </tr>
  </thead>
  <tbody>
    ";
        // line 15
        if (twig_test_empty($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "data", array()))) {
            // line 16
            echo "      <tr>
        <td colspan=\"8\">There are no data in the database.</td>
      </tr>
    ";
        } else {
            // line 20
            echo "      ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "data", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 21
                echo "        <tr>
          <td>";
                // line 22
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "id", array()), "html", null, true));
                echo "</td>
          <td><a href=\"";
                // line 23
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "link", array()), "html", null, true));
                echo "/";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "id", array()), "html", null, true));
                echo "\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, twig_title_string_filter($this->env, twig_replace_filter($this->getAttribute($context["item"], "title", array()), array("_" => " "))), "html", null, true));
                echo "</a></td>
          <td>";
                // line 24
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "mapid", array()), "html", null, true));
                echo "</td>
          <td>";
                // line 25
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, twig_title_string_filter($this->env, $this->getAttribute($context["item"], "description", array())), "html", null, true));
                echo "</td>
          <td>";
                // line 26
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "image", array()), "html", null, true));
                echo "</td>
          <td><a href=\"";
                // line 27
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "link", array()), "html", null, true));
                echo "/";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "id", array()), "html", null, true));
                echo "/ae\"><button style=\"margin-bottom:10px;\" class=\"button button-default\">Edit</button></a>
           <a href=\"";
                // line 28
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "link", array()), "html", null, true));
                echo "/";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "id", array()), "html", null, true));
                echo "/d\"><button style=\"margin-bottom:10px;\" class=\"button\">Delete</button></a></td>
        </tr>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            echo "    ";
        }
        // line 32
        echo "  </tbody>
</table>";
    }

    public function getTemplateName()
    {
        return "modules/bethelks_facilities/templates/facility-list-admin-template.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 32,  121 => 31,  110 => 28,  104 => 27,  100 => 26,  96 => 25,  92 => 24,  84 => 23,  80 => 22,  77 => 21,  72 => 20,  66 => 16,  64 => 15,  48 => 2,  43 => 1,);
    }

    public function getSource()
    {
        return "<a href=\"{{items.link}}/0/ae\"><button style=\"margin-bottom:10px;\" class=\"button button-action button--primary\">Add facility</button></a>
<h1>{{ items.title }}</h1>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Mapid</th>
      <th>title</th>
      <th>description</th>
      <th>image</th>
      <th>action</th>
    </tr>
  </thead>
  <tbody>
    {% if items.data is empty %}
      <tr>
        <td colspan=\"8\">There are no data in the database.</td>
      </tr>
    {% else %}
      {% for item in items.data %}
        <tr>
          <td>{{ item.id }}</td>
          <td><a href=\"{{items.link}}/{{item.id}}\">{{ item.title | replace({'_':' '}) | title }}</a></td>
          <td>{{ item.mapid }}</td>
          <td>{{ item.description | title }}</td>
          <td>{{ item.image }}</td>
          <td><a href=\"{{items.link}}/{{ item.id }}/ae\"><button style=\"margin-bottom:10px;\" class=\"button button-default\">Edit</button></a>
           <a href=\"{{items.link}}/{{ item.id }}/d\"><button style=\"margin-bottom:10px;\" class=\"button\">Delete</button></a></td>
        </tr>
      {% endfor %}
    {% endif %}
  </tbody>
</table>";
    }
}
