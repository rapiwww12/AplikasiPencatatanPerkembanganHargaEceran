interface PaginationProps {
    currentPage: number;
    totalItems: number;
    itemsPerPage: number;
    onPageChange: (page: number) => void;
}

export const Pagination = ({ currentPage, totalItems, itemsPerPage, onPageChange }: PaginationProps) => {
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    return (
        <div className="flex justify-center space-x-2 mt-4">
            <button
                onClick={() => onPageChange(currentPage - 1)}
                disabled={currentPage === 1}
                className="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
            >
                Previous
            </button>

            <span className="px-4 py-2">{`${currentPage} / ${totalPages}`}</span>

            <button
                onClick={() => onPageChange(currentPage + 1)}
                disabled={currentPage === totalPages}
                className="px-4 py-2 bg-gray-200 rounded disabled:opacity-50"
            >
                Next
            </button>
        </div>
    );
};
