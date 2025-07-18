<?php

namespace Chat;

use \Chat\Http\Request;
use \Chat\Util\LazyServiceLocator;
use \Chat\Util\Logger;

/**
 * Represents a Chat web application.
 */
class Application
{
    use Inject\HtmlRenderer;


    /**
     * Runs application as an enter point for HTTP requests.
     */
    public function run()
    {
        $this->init();
        $request = new Request();
        try {
            $request->parseSuperGlobal();
            $page = Page::create($request->page);
            $page = $page->process($request);
            $this->initHtmlRenderer()->renderPage($page);
        } catch (\Throwable $e) {
            if (Conf::$isDebugMode)
                throw $e;
            else
                Logger::log($this, $e);
        }
    }

    /**
     * Initializes application core and injects dependencies into IoC-container
     * that must be used during HTTP requests processing or by default.
     *
     * Almost all dependencies are "lazy" (injected as anonymous functions,
     * so they will be evaluated only when this is required).
     */
    public function init()
    {
        $injector = new LazyServiceLocator();
        Injector::$instance = $injector;

        $injector->bindLazySingletons([
            'HtmlRenderer' => function () {
                return new Renderer\Twig(
                    PROJECT_ROOT.'/templates/',
                    Conf::$isDebugMode,
                    PROJECT_ROOT.'/.cache/twig/'
                );
            },
            'MySQL' => function () {
                throw new \Exception('Not Implemented');
            },
        ]);
    }
}
