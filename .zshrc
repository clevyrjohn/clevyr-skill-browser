alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
alias reseed='[ -f sail ] && bash sail artisan migrate:fresh --seed || bash vendor/bin/sail artisan migrate:fresh --seed'
alias logs='[ -f sail ] && bash sail logs -f || bash vendor/bin/sail logs -f'
alias reindex='[ -f .index.sh ] && bash .index.sh'