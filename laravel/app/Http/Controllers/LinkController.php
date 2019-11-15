<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LinkController extends Controller
{
    protected $_linkService;

    public function __construct(LinkService $linkService)
    {
        $this->_linkService = $linkService;
    }

    /**
     * Action for adding new link
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'url' => 'required',
        ]);
        $link = $this->_linkService->addLink($request->get('url'));

        return [
            'short_url' => route('linkRedirect', ['hash' => $link->hash]),
            'secret_url' => route('linkEditDelete', ['hash' => $link->hash, 'secret_key' => $link->secret_key]),
        ];
    }

    /**
     * Action for redirect from short link to full url
     *
     * @param $hash
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function redirect($hash)
    {
        $link = $this->_linkService->getLinkByHash($hash);
        if (false === $link) {
            return response('Link not found', 404);
        }

        return redirect($link->url);
    }

    /**
     * Action for control link
     *
     * @param Request $request
     * @param $hash
     * @param $secret_key
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|int|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editDelete(Request $request, $hash, $secret_key)
    {
        $link = $this->_linkService->getLinkByHash($hash);
        if (false === $link) {
            return response('Link not found', 404);
        }

        if ($secret_key !== $link->secret_key) {
            return response('Access denied', 403);
        }

        switch ($request->method()) {
            case 'PUT':
                $this->validate($request, [
                    'url' => 'required',
                ]);
                $this->_linkService->updateLink($link, $request->get('url'));

                break;
            case 'DELETE':
                $this->_linkService->deleteLink($link);
                break;
        }

        return response('No Content', 204);
    }
}
