# codespace-scripts

Skript i denna mapp hjälper till att starta och stoppa lokal utvecklingsmiljö, särskilt i Codespaces/Linux.

## Filer

- [`start.sh`](start.sh) – startar webben via Docker/Podman om tillgängligt, annars via PHP:s inbyggda server.
- [`stop.sh`](stop.sh) – stoppar lokal miljö (process på port och/eller container).

## Användning

Från repo-roten:

```bash
bash ./codespace-scripts/start.sh
```

Stoppa miljön:

```bash
bash ./codespace-scripts/stop.sh
```

Valfri port vid stopp:

```bash
bash ./codespace-scripts/stop.sh 8080
```

## Relaterad dokumentation

- [Root README](../README.md)
- [test-guide](../tests/ReadMe.md)
- [utvecklingsskript](../dev-scripts/ReadMe.md)
