import AppLogoIcon from './app-logo-icon';

export default function AppLogo() {
    return (
        <>
            <div className="text-sidebar-primary-foreground flex aspect-square size-17 items-center justify-center rounded-md">
                <img
                src="/Logo_banyuasin.png"
                 alt="Foto Kabupaten Banyuasin"
                />
            </div>
            <div className="ml-1 flex flex-1 flex-wrap text-left text-sm">
            <span className="mb-0.5 leading-none font-semibold">Sekretariat Daerah Kabupaten Banyuasin</span>
            </div>

        </>
    );
}
