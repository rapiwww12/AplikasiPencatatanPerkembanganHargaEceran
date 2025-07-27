import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader } from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { can } from '@/utils/permission';
import { Head, useForm, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Laporan',
        href: '/laporan',
    },
];

interface Laporan {
    id: number;
    judul: string;
    kesimpulan: string;
    tanggal_mulai: string;
    tanggal_selesai: string;
    file_path: string;
}

interface Props {
    laporans?: Laporan[];
    flash: {
        success: string | null;
        error: string | null;
    };
}

export default function LaporanIndex({ laporans, flash }: Props) {
    const [open, setOpen] = useState(false);
    const [laporanToDelete, setLaporanToDelete] = useState<number | null>(null);
    const [generateDialogOpen, setGenerateDialogOpen] = useState(false);

    const page = usePage().props as {
        auth?: {
            permissions: string[];
            roles?: string[];
        };
    };

    const auth = page.auth ?? { permissions: [] };

    const { data, setData, post, processing, reset, errors } = useForm({
        judul: '',
        kesimpulan: '',
    });

    const handleDelete = (id: number) => {
        setLaporanToDelete(id);
        setOpen(true);
    };

    const confirmDelete = () => {
        if (laporanToDelete) {
            toast.success('Laporan berhasil dihapus');
            setOpen(false);
        }
    };

    useEffect(() => {
        if (flash.success) toast.success(flash.success);
        if (flash.error) toast.error(flash.error);
    }, [flash]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Laporan" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Laporan</h1>
                    {can('create-laporan', auth) && (
                        <Button className="bg-primary" onClick={() => setGenerateDialogOpen(true)}>
                            Buat Laporan Baru
                        </Button>
                    )}
                </div>

                <Table className="mt-4">
                    <TableHeader>
                        <TableRow>
                            <TableHead>Judul</TableHead>
                            <TableHead>Tanggal Mulai</TableHead>
                            <TableHead>Tanggal Selesai</TableHead>
                            <TableHead>File</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {!laporans || laporans.length === 0 ? (
                            <TableRow>
                                <TableCell colSpan={5} className="text-center">
                                    Tidak ada laporan tersedia.
                                </TableCell>
                            </TableRow>
                        ) : (
                            laporans.map((laporan) => (
                                <TableRow key={laporan.id}>
                                    <TableCell>{laporan.judul}</TableCell>
                                    <TableCell>{laporan.tanggal_mulai}</TableCell>
                                    <TableCell>{laporan.tanggal_selesai}</TableCell>
                                    <TableCell>
                                        <a href={`storage/${laporan.file_path}`} target="_blank" className="text-blue-500">
                                            Lihat Laporan
                                        </a>
                                    </TableCell>
                                    <TableCell className="flex space-x-2">
                                        {can('download-laporan', auth) && (
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <a href={`/laporan/download/${laporan.id}`} target="_blank" rel="noopener noreferrer">
                                                        <Button variant="outline" size="sm">
                                                            Download
                                                        </Button>
                                                    </a>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Delete</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))
                        )}
                    </TableBody>
                </Table>

                <Dialog open={generateDialogOpen} onOpenChange={setGenerateDialogOpen}>
                    <DialogContent>
                        <DialogHeader>
                            <h3 className="text-lg font-semibold">Buat Laporan Baru</h3>
                        </DialogHeader>
                        <div className="mt-4 space-y-2">
                            <label htmlFor="judul" className="block text-sm font-medium">
                                Judul Laporan
                            </label>
                            <input
                                type="text"
                                id="judul"
                                value={data.judul}
                                onChange={(e) => setData('judul', e.target.value)}
                                className="w-full rounded border px-3 py-2 text-sm"
                            />
                            {errors.judul && <p className="text-sm text-red-500">{errors.judul}</p>}
                        </div>
                        <div className="mt-4 space-y-2">
                            <label htmlFor="kesimpulan" className="block text-sm font-medium">
                                Kesimpulan
                            </label>
                            <textarea
                                id="kesimpulan"
                                value={data.kesimpulan}
                                onChange={(e) => setData('kesimpulan', e.target.value)}
                                className="w-full rounded border px-3 py-2 text-sm"
                            />
                            {errors.judul && <p className="text-sm text-red-500">{errors.judul}</p>}
                            {errors.kesimpulan && <p className="text-sm text-red-500">{errors.kesimpulan}</p>}
                        </div>
                        <DialogFooter>
                            <Button variant="outline" onClick={() => setGenerateDialogOpen(false)}>
                                Batal
                            </Button>
                            <Button
                                className="bg-primary"
                                disabled={processing}
                                onClick={() => {
                                    post('laporan/generate', {
                                        onSuccess: () => {
                                            toast.success('Laporan berhasil dibuat!');
                                            setGenerateDialogOpen(false);
                                            reset();
                                        },
                                        onError: () => toast.error('Gagal membuat laporan'),
                                    });
                                }}
                            >
                                Generate
                            </Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            </div>
        </AppLayout>
    );
}
