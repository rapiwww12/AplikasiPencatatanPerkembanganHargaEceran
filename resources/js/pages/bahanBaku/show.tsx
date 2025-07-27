import { Button } from '@/components/ui/button';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationLink,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { can } from '@/utils/permission';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { z } from 'zod';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';



interface Harga {
    id: number;
    bahan_baku_id: number;
    harga: string;
    tanggal: string;
    pasar: string;
}

interface BahanBaku {
    id: number;
    nama: string;
    satuan: string;
}

interface Props {
    bahanBaku: BahanBaku;
    hargas: Harga[];
    currentPage: number;
    lastPage: number;
    perPage: number;
}

const formSchema = z.object({
    harga: z.string().min(1, 'Harga bahan baku wajib diisi'),
});

export default function ShowHarga({ bahanBaku, hargas, currentPage, lastPage }: Props) {
    const handlePageChange = (page: number) => {
        if (page >= 1 && page <= lastPage) {
            router.visit(`?page=${page}`);
        }
    };

    const page = usePage().props as {
        auth?: {
            permissions: string[];
            roles?: string[];
        };
    };

    const auth = page.auth ?? { permissions: [] };

    const pageNumbersToShow = 3;

    const pageNumbers = Array.from({ length: lastPage }, (_, i) => i + 1);

    let displayedPageNumbers: (number | '...')[] = pageNumbers.slice(0, pageNumbersToShow);

    if (lastPage > pageNumbersToShow * 2) {
        displayedPageNumbers.push('...');
        displayedPageNumbers.push(...pageNumbers.slice(-pageNumbersToShow));
    } else {
        displayedPageNumbers.push(...pageNumbers.slice(pageNumbersToShow));
    }

    return (
        <AppLayout
            breadcrumbs={[
                { title: 'Bahan Baku', href: '/items' },
                { title: 'Harga', href: `/items/${bahanBaku.id}` },
                { title: bahanBaku.nama, href: '#' },
            ]}
        >
            <Head title={`Harga ${bahanBaku.nama}`} />
            <div className="space-y-4 p-6">
                <div className="flex justify-between">
                    <div>
                        <h1 className="text-2xl font-semibold">Daftar Harga - {bahanBaku.nama}</h1>
                        <p className="text-sm text-gray-500">Satuan: {bahanBaku.satuan}</p>
                    </div>
                    <div>
                        <Link href={`/items`}>
                            <Button type="button">Kembali</Button>
                        </Link>
                    </div>
                </div>

                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nama Barang</TableHead>
                            <TableHead>Pasar</TableHead>
                            <TableHead>Harga</TableHead>
                            <TableHead>Tanggal</TableHead>
                            <TableHead>Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {hargas.length === 0 ? (
                            <TableRow>
                                <TableCell colSpan={3} className="text-center text-red-500 italic">
                                    Belum ada data harga.
                                </TableCell>
                            </TableRow>
                        ) : (
                            hargas.map((harga) => (
                                <TableRow key={harga.id}>
                                    <TableCell>{bahanBaku.nama}</TableCell>
                                    <TableCell>{harga.pasar}</TableCell>
                                    <TableCell>Rp {parseInt(harga.harga).toLocaleString('id-ID')}</TableCell>
                                    <TableCell>{new Date(harga.tanggal).toLocaleDateString('id-ID')}</TableCell>
                                    <TableCell>
                                        {can('edit-harga', auth) && (
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <Link href={`/items/harga/${harga.id}/edit`}>
                                                        <Button>Edit</Button>
                                                    </Link>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Edit</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))
                        )}
                    </TableBody>
                </Table>

                <Pagination className="mt-10">
                    <PaginationContent>
                        <PaginationItem>
                            <PaginationPrevious
                                href="#"
                                onClick={(e) => {
                                    e.preventDefault();
                                    handlePageChange(currentPage - 1);
                                }}
                                className={currentPage === 1 ? 'cursor-not-allowed text-gray-400' : ''}
                            />
                        </PaginationItem>

                        {displayedPageNumbers.map((page, index) => (
                            <PaginationItem key={index}>
                                {page === '...' ? (
                                    <PaginationEllipsis />
                                ) : (
                                    <PaginationLink
                                        href="#"
                                        onClick={(e) => {
                                            e.preventDefault();
                                            if (typeof page === 'number') {
                                                handlePageChange(page);
                                            }
                                        }}
                                        isActive={page === currentPage}
                                    >
                                        {page}
                                    </PaginationLink>
                                )}
                            </PaginationItem>
                        ))}

                        <PaginationItem>
                            <PaginationNext
                                href="#"
                                onClick={(e) => {
                                    e.preventDefault();
                                    handlePageChange(currentPage + 1);
                                }}
                                className={currentPage === lastPage ? 'cursor-not-allowed text-gray-400' : ''}
                            />
                        </PaginationItem>
                    </PaginationContent>
                </Pagination>
            </div>
        </AppLayout>
    );
}
