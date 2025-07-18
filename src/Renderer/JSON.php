<?php

namespace Chat\Renderer;

use \Chat\Page;
use \Chat\Renderer;


/**
 * Implements JSON renderer.
 */
class JSON implements Renderer
{
    /**
     * Renders specified page and prints it immediately.
     * Sets HTTP status response code accordingly to code in passed page.
     *
     * @param Page $page  Page to render.
     */
    public function renderPage(Page $page): void
    {
		header('Content-Type: application/json; charset=utf-8');
        echo $this->renderHtml($page->alias, $page->toJSON);
    }

    /**
     * Renders JSON template.
     *
     * @param string $alias  Alias of template to be rendered.
     * @param array $params  Parameters for template rendering.
     *
     * @return string  Rendered JSON template.
     */
    public function renderHtml(string $alias, array $params): string
    {
        return json_encode($params);
    }
}
