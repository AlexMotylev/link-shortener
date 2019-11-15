<?php

namespace App\Services;

use App\Link;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class LinkService
{
    protected $_secretKeyLength = 16;

    public function __construct($options = [])
    {
        if (isset($options['secretKeyLength'])) {
            $this->_secretKeyLength = $options['secretKeyLength'];
        }
    }

    /**
     * Add new link
     *
     * @param $url
     * @return Link
     * @throws ValidationException, QueryException
     */
    public function addLink($url)
    {
        $link = new Link();
        $link->hash = uniqid();
        $link->secret_key = bin2hex(random_bytes($this->_secretKeyLength));
        $link->url = $url;
        $link->validate();
        $link->save();

        return $link;
    }

    /**
     * Update existing link
     *
     * @param Link $link
     * @param $url
     * @return bool
     * @throws ValidationException
     */
    public function updateLink(Link $link, $url){
        $link->url = $url;
//        var_dump($link->url);
        $link->validate();
        return $link->save();

    }

    /**
     * Delete existing link
     *
     * @param Link $link
     * @return bool|null
     * @throws \Exception
     */
    public function deleteLink(Link $link){
        return $link->delete();
    }

    /**
     * Get link by hash
     *
     * @param $hash
     * @return bool|Link
     */
    public function getLinkByHash($hash)
    {
        $results = Link::query()->where(['hash' => $hash])->get();
        return count($results) ? $results[0] : false;
    }

}
