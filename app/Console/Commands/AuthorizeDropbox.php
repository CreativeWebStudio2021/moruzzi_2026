<?php

namespace App\Console\Commands;

use App\Services\DropboxTokenManager;
use Illuminate\Console\Command;

class AuthorizeDropbox extends Command
{
    protected $signature = 'dropbox:authorize {code? : Codice OAuth incollato dopo l\'autorizzazione}';

    protected $description = 'Ottiene refresh token Dropbox per la sincronizzazione automatica';

    public function handle(): int
    {
        $manager = new DropboxTokenManager(
            appKey: config('dropbox_sync.app_key'),
            appSecret: config('dropbox_sync.app_secret'),
            accessToken: null,
            refreshToken: null,
            tokenCacheFile: config('dropbox_sync.token_cache_file'),
        );

        try {
            $url = $manager->authorizationUrl();
        } catch (\Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->line('1. Apri questo URL nel browser (account Dropbox che possiede la cartella):');
        $this->newLine();
        $this->comment($url);
        $this->newLine();
        $this->line('2. Autorizza l\'app. Dropbox mostrerà un codice (se non hai redirect URI).');
        $this->line('3. Incolla il codice qui sotto.');

        $code = $this->argument('code') ?? $this->ask('Codice OAuth');

        if ($code === null || trim($code) === '') {
            $this->error('Codice mancante.');

            return self::FAILURE;
        }

        try {
            $tokens = $manager->exchangeAuthorizationCode(trim($code));
        } catch (\Throwable $e) {
            $this->error('Scambio codice fallito: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Autorizzazione riuscita. Aggiungi al .env:');
        $this->newLine();
        $this->line('DROPBOX_REFRESH_TOKEN='.$tokens['refresh_token']);
        $this->line('DROPBOX_ACCESS_TOKEN=');

        if ($tokens['refresh_token'] === '') {
            $this->warn('Refresh token non restituito: verifica token_access_type=offline nell\'URL.');
            $this->line('DROPBOX_ACCESS_TOKEN='.$tokens['access_token']);
        }

        return self::SUCCESS;
    }
}
