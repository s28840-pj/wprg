{
  inputs.nixpkgs.url = "github:NixOS/nixpkgs/nixpkgs-unstable";

  outputs = {
    nixpkgs,
    self,
  }: let
    forEachSystem = f:
      nixpkgs.lib.genAttrs [
        "x86_64-linux"
        "aarch64-darwin"
      ] (system: f nixpkgs.legacyPackages.${system});
  in {
    devShells = forEachSystem (pkgs: {
      default = pkgs.mkShellNoCC {
        packages = [
          pkgs.php
          (pkgs.writeShellScriptBin "php-serv" "${pkgs.lib.getExe pkgs.php} -S localhost:8080")
        ];
      };
    });

    formatter = forEachSystem (builtins.getAttr "alejandra");
  };
}
