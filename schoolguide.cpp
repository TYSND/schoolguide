#include<iostream>
#include "/usr/include/mysql/mysql.h" 
#include<sstream> 
#include<string>
#include<fstream>
#include<stdlib.h>
#include<queue>
#include<string.h>
#define HOST "localhost"
#define USERNAME "root"
#define PASSWORD "******"
#define DATABASE "schoolguide"
/*
g++ schoolguide.cpp -o schoolguide -I /usr/include/mysql -L /usr/lib/mysql -l mysqlclient -lz -lm
g++ upload.cpp.cpp -o upload -I /usr/include/mysql -L /usr/lib/mysql -l mysqlclient -lz -lm
*/
using namespace std;
const int maxv=1e6+10,maxe=1e6+10;
int head[maxv];
struct Edge
{
	int to,nxt,dist,cap,vol;
};
Edge edge[2*maxe];
int s,t; 
const int IM=(1<<30);

int en=0;
//spfa data;
int dis[maxv],pre[maxv],inque[maxv];
//dinic data;
int dist[maxv];
queue<int> que;
bool vis[maxv];

//spfa function
void shortpathgraph();
void spfa(int);
//dinic function
void maxflowpathgraph();
void bfs();
int dfs(int,int);
int maxflow();

//get data from mysql
void query_sql(string& sql) ;

int einfo[maxv+5][4];
int main(int argc,char* argv[])
{
	freopen("result.out","w",stdout);
	//select vertex and edge information from mysql
	string query = "select * from edgeinfo ;";
	
	query_sql(query);
	

	//make graph over//
	int mode=atoi(argv[1]);
	s=atoi(argv[2]),t=atoi(argv[3]);
	if(mode==0)//shortest path
	{
		shortpathgraph();
		for(int i=1;i<maxv;i++)
		{
			dis[i]=IM;
			inque[i]=0;
		}
		spfa(s);
//		cout<<dis[t]<<endl;
//		return 0;
		if(dis[t]==IM)
			cout<<"can't reach"<<endl;
		else
		{
			cout<<dis[t]<<endl;
			cout<<t<<endl;
			int p=t;
			while(1)
			{
				cout<<pre[p]<<endl;
				p=pre[p];
				if(p==s)	break;
			}
		}
		
	}
	else if(mode==1)//max flow
	{
		maxflowpathgraph();
		cout<<maxflow()<<endl;
		for(int i=1;i<=2*en;i++)
		{
			if(edge[i].vol!=edge[i].cap)
			{
				int f;
				for(f=1;f<maxv;f++)
				{
					int k=0;
					for(k=head[f];k;k=edge[k].nxt)
					{
						if(k==i)	break;
					}
					if(k)	break;
				}
				cout<<f<<endl;cout<<edge[i].to<<endl;
			}
		}
	}
	/*
	for(int i=0;i<argc;i++)
		cout<<argv[i]<<" ";	
	cout<<endl;
	*/
	
	return 0;
}
void shortpathgraph()
{
	for(int i=1;i<=en;i++)
	{
		edge[i].to=einfo[i][1];
		edge[i].dist=einfo[i][2];
		edge[i].cap=einfo[i][3];
		edge[i].nxt=head[einfo[i][0]];
		head[einfo[i][0]]=i;
	}
}
void spfa(int s)
{
	queue<int> q;
	q.push(s);
	dis[s]=0;
	inque[s]=1;
	while(!q.empty())
	{
		int cur=q.front();
		q.pop();
		inque[cur]=0;
		for(int k=head[cur];k;k=edge[k].nxt)
		{
			if(dis[edge[k].to]>dis[cur]+edge[k].dist)
			{
				dis[edge[k].to]=dis[cur]+edge[k].dist;
				pre[edge[k].to]=cur;
				if(!inque[edge[k].to])
					q.push(edge[k].to);
			}
		}
	}
}

void maxflowpathgraph()
{
	int eid=1;
	for(int i=1;i<=en;i++)
	{
		int f=einfo[i][0],to=einfo[i][1],cap=einfo[i][3];
		
		eid++;
		edge[eid].to=to;
		//edge[i].dist=einfo[i][2];
		edge[eid].cap=cap;
		edge[eid].vol=cap;
		edge[eid].nxt=head[f];
		head[f]=eid;
		eid++;
		//reverse edge
		edge[eid].to=f;
		//edge[i].dist=einfo[i][2];
		edge[eid].cap=0;
		edge[eid].vol=0;
		edge[eid].nxt=head[to];
		head[to]=eid;
	}
}

void bfs()
{
	memset(dist,0,sizeof(dist));
	while(!que.empty())	que.pop();
	vis[s]=true;
	que.push(s);
	while(!que.empty())
	{
		int u=que.front();
		que.pop();
		for(int i=head[u];i;i=edge[i].nxt)
		{
			if(edge[i].cap&&!vis[edge[i].to])
			{
				que.push(edge[i].to);
				dist[edge[i].to]=dist[u]+1;
				vis[edge[i].to]=true;
			}
		}
	}
}

int dfs(int u,int delta)
{
	if(u==t)
	{
		return delta;
	}
	else
	{
		int ret=0;
		for(int i=head[u];delta&&i;i=edge[i].nxt)
		{
			if(edge[i].cap&&dist[edge[i].to]==dist[u]+1)
			{
				int dd=dfs(edge[i].to,min(edge[i].cap,delta));
				edge[i].cap-=dd;
				edge[i^1].cap+=dd;
				delta-=dd;
				ret+=dd;
			}
		}
		return ret;
	}
}
int maxflow()
{
	int ret=0;
	while(true)
	{
		memset(vis,0,sizeof(vis));
		bfs();
		if(!vis[t])	return ret;
		ret+=dfs(s,IM);
	}
}

void query_sql(string& sql) 
{
    MYSQL my_connection;
    int res; 
    MYSQL_RES *res_ptr; 
    MYSQL_FIELD *field; 
    MYSQL_ROW result_row; 

    int row, column;
    int i, j; 

    
    mysql_init(&my_connection);

   
    if (mysql_real_connect(&my_connection, HOST, USERNAME, PASSWORD, DATABASE, 0, NULL, CLIENT_FOUND_ROWS)) 
    {
	   
	   
	    mysql_query(&my_connection, "set names utf8");
	  
	    res = mysql_query(&my_connection, sql.c_str());
	
	    if (res) 
	    { 
	        printf("Error ");
			cout << mysql_error(&my_connection)<< endl;
	       
	        mysql_close(&my_connection);
	    }
	    else 
	    { 
	        
	        res_ptr = mysql_store_result(&my_connection);
	
	        
	        if (res_ptr) 
	        {
	        	unsigned int num_fields = mysql_num_fields(res_ptr);
	        	int eid=1;
	        	while(result_row=mysql_fetch_row(res_ptr))
	        	{
	        		//make graph
	        		int to=atoi(result_row[1]);
	        		int dist=atoi(result_row[2]);
	        		int cap=atoi(result_row[3]);
	        		int f=atoi(result_row[0]);
	        		
	        		einfo[eid][0]=f;
	        		einfo[eid][1]=to;
	        		einfo[eid][2]=dist;
	        		einfo[eid][3]=cap;
	        		eid++;
	        		/*
	        		edge[eid].to=to;
	        		edge[eid].dist=dist;
	        		edge[eid].cap=cap;
	        		edge[eid].nxt=head[f];
	        		head[f]=eid;
	        		*/
	        		/*
	        		for (int i = 0; i < num_fields; i++)
	        		{
	        			cout<<result_row[i]<<" ";
					}
					cout<<endl;
					*/
				}
				en=eid-1;
		        /*
		        column = mysql_num_fields(res_ptr);
		        row = mysql_num_rows(res_ptr) + 1;
		        
		
		       
		        for (i = 0; field = mysql_fetch_field(res_ptr); i++)
		            printf("%s\t", field->name);
		        printf("\n");
		
		        
		        for (i = 1; i < row; i++)
		        {
		            result_row = mysql_fetch_row(res_ptr);
		            for (j = 0; j < column; j++)
		            printf("%s\t", result_row[j]);
		            printf("\n");  
		        }  
		        */
		
	        }  
	
	        
	        mysql_close(&my_connection);
			mysql_free_result(res_ptr); 
	    }  
    }  
} 

