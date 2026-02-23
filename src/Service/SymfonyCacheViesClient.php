<?php
namespace Belghiti\Vies\Symfony\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Belghiti\Vies\Client\ViesClientInterface;
use Belghiti\Vies\Dto\CheckVatRequest;
use Belghiti\Vies\Dto\CheckVatResponse;
use Belghiti\Vies\Dto\StatusInformationResponse;

final class SymfonyCacheViesClient implements ViesClientInterface
{
    public function __construct(private ViesClientInterface $inner, private CacheInterface $cache, private int $ttl) {}

    public function checkVatNumber(CheckVatRequest $request): CheckVatResponse
    {
        $key = 'belghiti_vies:vat:'.md5($request->countryCode.':'.$request->vatNumber);
        return $this->cache->get($key, function ($item) use ($request) {
            $item->expiresAfter($this->ttl);
            return $this->inner->checkVatNumber($request);
        });
    }
    public function checkVatTestService(CheckVatRequest $request): CheckVatResponse
    { return $this->inner->checkVatTestService($request); }
    public function checkStatus(): StatusInformationResponse
    { return $this->inner->checkStatus(); }
}
