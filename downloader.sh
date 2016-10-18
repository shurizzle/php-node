#!/bin/sh

VERSION=6.8.0
DEST="bins"

cd "$(dirname "$0")"

if ! which realpath >/dev/null 2>/dev/null; then
  if [ `uname` = 'Darwin' ]; then
    if which greadlink >/dev/null 2>/dev/null; then
      realpath() {
        greadlink -f "$1"
      }
    else
      realpath() {
        osascript -e 'tell application "Finder"' -e "posix path of (original item of alias file (posix file \"$1\") as text)" -e 'end tell'
      }
    fi
  else
    realpath() {
      readlink -f "$1"
    }
  fi
fi

mkdir -p "$DEST" || exit 1

DEST="$(realpath "$DEST")"

if which wget >/dev/null 2>/dev/null; then
  download() {
    wget --timeout=3 -t 3 --waitretry=1 -c "$1" -O "$2" || exit 1
  }
elif which curl >/dev/null 2>/dev/null; then
  download() {
    curl --connect-timeout 3 --retry 3 --retry-delay 1 -c "$1" -o "$2" || exit 1
  }
else
  exit 1
fi

download_extract() {
  download "$1" "$2"."$3"
  tar xvf "$2"."$3" || exit 1
  cp -a "$2"/bin/node "$DEST/$4" || exit 1
  chmod +x "$DEST/$4" || exit 1
}

do_windows() {
  local FILE="win-${1}-node.exe"
  download "https://nodejs.org/dist/v${VERSION}/win-${1}/node.exe" "$FILE"
  chmod +x "$FILE" || exit 1

  cp -a "$FILE" "$DEST/$FILE" || exit 1
}

do_darwin() {
  local DIR="node-v${VERSION}-darwin-x64"
  download_extract "https://nodejs.org/dist/v${VERSION}/${DIR}.tar.gz" "$DIR" tar.gz darwin-x64-node || exit 1
}

do_linux() {
  local DIR="node-v${VERSION}-linux-${1}"
  download_extract "https://nodejs.org/dist/v${VERSION}/${DIR}.tar.xz" "$DIR" tar.xz linux-"${1}"-node || exit 1
}

mkdir -p downloads || exit 1
cd downloads || exit 1

do_windows x86
do_windows x64

do_darwin

do_linux x86
do_linux x64
do_linux armv6l
do_linux armv7l
do_linux arm64

cd ..
