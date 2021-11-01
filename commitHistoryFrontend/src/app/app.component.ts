import { Component } from '@angular/core';
import { CommitHistory } from './interfaces/commitHistory';
import { HistoryService } from './services/history.service';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})

export class AppComponent {
  public commits: Array<CommitHistory>;
  public displayedColumns = ['author', 'commit_date', 'sha'];
  public searchApplied: boolean = false;
  public message_text: string;

  constructor( private historyService: HistoryService) {

  }

  ngOnInit() {
    this.getCommits();
  }

  /**
   * Get all commits or commits of an author
   *
   * @param {string} author author name
   */
  public getCommits(author?: string): void {
    this.message_text = 'Loading...';
    this.historyService.getCommitsHistroy(author)
    .then(data => {
          this.searchApplied = author? true: false;
          this.commits = data;
    })
    .catch(error => {
          this.message_text = error;
          console.log(error);
    })
  }

  
  /**
   * Check if commits data exist
   *
   * @return {boolean}
   */
  public dataExist(): boolean {
    if ( this.commits?.length ) {
      return true;
    }    
    this.message_text = 'Data not Found';
    return false;
  }
}
