# Deploy av webbsidan

Projektet deployas via GitHub Actions och SFTP.

## Produktion

- Workflow: [`.github/workflows/deploy.yml`](../.github/workflows/deploy.yml)
- Trigger: push till `main`
- Publicerar innehållet i `src/` till webbroten
- Skapar `src/version.txt` i formatet `v14.yyyyMMdd.hhmm`

## Beta

- Workflow: [`.github/workflows/deploy-beta.yml`](../.github/workflows/deploy-beta.yml)
- Trigger: push till brancher som börjar med `dev` eller `feature`
- Publicerar innehållet i `src/` till `/beta/`
- Skapar `src/version.txt` i formatet `v14.yyyyMMdd.hhmm-beta`
- Skriver om absoluta länkar (`href="/`, `src="/`) till `/beta/` före uppladdning

## Secrets

Båda deploy-workflows använder SFTP-secrets i GitHub Actions:

- `SFTP_USER`
- `SFTP_PASSWORD`
- `SFTP_HOST`
