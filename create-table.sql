create table [dbo].[Registration](
    id INT NOT NULL IDENTITY(1,1) PRIMARY KEY(id),
    name VARCHAR(30),
    nomer VARCHAR(30),
    asal VARCHAR(30),
    date DATE
);