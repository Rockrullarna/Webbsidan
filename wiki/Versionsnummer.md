# Versionsnummer

## Hur version.txt skapas

Versionsfilen skapas i deploy-workflows:

- [`.github/workflows/deploy.yml`](../.github/workflows/deploy.yml) (produktion)
- [`.github/workflows/deploy-beta.yml`](../.github/workflows/deploy-beta.yml) (beta)

Nuvarande format:

- Produktion: `v14.yyyyMMdd.hhmm`
- Beta: `v14.yyyyMMdd.hhmm-beta`

`14` avser webbplatsens nuvarande huvudgeneration (v14) och uppdateras bara vid byte till ny huvudgeneration.

Exempel från workflow:

```yml
- name: Add version.txt file
  run: echo "v14.$(date +'%Y%m%d').$(date +'%H%M')" > ./src/version.txt
```

## Hur versionen visas på sajten

Sajten läser in `https://rockrullarna.se/version.txt` i footern via PHP och visar versionssträngen för användaren.

Observera att lokala testmiljöer utan extern nätverksåtkomst kan få varningar om uppslag av `rockrullarna.se`.
