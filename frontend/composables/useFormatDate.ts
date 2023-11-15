const useFormatDate = (date: string): string => {
  const parsed = new Date(date)

  return parsed.toLocaleDateString() as string;
}

export default useFormatDate;
